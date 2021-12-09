<?php

namespace HDSSolutions\Laravel\Http\Controllers;

use App\Http\Controllers\Controller;
use HDSSolutions\Laravel\DataTables\PriceListVersionDataTable as DataTable;
use HDSSolutions\Laravel\Http\Request;
use HDSSolutions\Laravel\Models\PriceListVersion as Resource;
use HDSSolutions\Laravel\Models\PriceList;
use HDSSolutions\Laravel\Models\Product;
use HDSSolutions\Laravel\Models\ProductPrice;
use Illuminate\Support\Facades\DB;

class PriceListVersionController extends Controller {

    public function __construct() {
        // check resource Policy
        $this->authorizeResource(Resource::class, 'resource');
    }

    public function index(Request $request, DataTable $dataTable) {
        // check only-form flag
        if ($request->has('only-form'))
            // redirect to popup callback
            return view('backend::components.popup-callback', [ 'resource' => new Resource ]);

        // load resources
        if ($request->ajax()) return $dataTable->ajax();

        // return view with dataTable
        return $dataTable->render('products-catalog::price_list_versions.index', [
            'count'                 => Resource::count(),
            'show_company_selector' => !backend()->companyScoped(),
        ]);
    }

    public function create(Request $request) {
        // force company selection
        if (!backend()->companyScoped()) return view('backend::layouts.master', [ 'force_company_selector' => true ]);

        // get PriceList
        $price_lists = PriceList::ordered()->with([ 'currency' ])->get();
        // get products
        $products = Product::ordered()->with([ 'images', 'variants' ])->get()
            // set relation of Variant.product manually to avoid more queries
            ->transform(fn($product) => $product
                // replace variants relation
                ->setRelation('variants', $product->variants->transform(fn($variant) => $variant
                    // set relation to parent manually
                    ->setRelation('product', $product)
            ))
        );

        // show create form
        return view('products-catalog::price_list_versions.create', compact('price_lists', 'products'));
    }

    public function store(Request $request) {
        // start a transaction
        DB::beginTransaction();

        // create resource
        $resource = new Resource( $request->input() );

        // save resource
        if (!$resource->save())
            // redirect with errors
            return back()->withInput()
                ->withErrors( $resource->errors() );

        // sync prices
        if (($redirect = $this->syncPrices($resource, $request->get('prices'))) !== true)
            // return redirection
            return $redirect;

        // confirm transaction
        DB::commit();

        // check return type
        return $request->has('only-form') ?
            // redirect to popup callback
            view('backend::components.popup-callback', compact('resource')) :
            // redirect to resources list
            redirect()->route('backend.price_list_versions');
    }

    public function show(Request $request, Resource $resource) {
        // redirect to list
        return redirect()->route('backend.price_list_versions');
    }

    public function edit(Request $request, Resource $resource) {
        // get PriceList
        $price_lists = PriceList::ordered()->with([ 'currency' ])->get();
        // get products
        $products = Product::ordered()->with([ 'images', 'variants' ])->get()
            // set relation of Variant.product manually to avoid more queries
            ->transform(fn($product) => $product
                // replace variants relation
                ->setRelation('variants', $product->variants->transform(fn($variant) => $variant
                    // set relation to parent manually
                    ->setRelation('product', $product)
            ))
        );

        // load product prices
        $resource->load([
            'prices' => fn($productPrice) => $productPrice
                // don't load prices with deleted products nor variants
                ->whereHas('product', fn($product) => $product->whereNull('deleted_at'))
                ->whereHas('variant', fn($variant) => $variant->whereNull('deleted_at'))
        ])
            // set relation to priceList manually
            ->setRelation('priceList', $price_lists->firstWhere('id', $resource->price_list_id))
            // override loaded prices, modify pivot relation to add parent manually
            ->setRelation('prices', $resource->prices->transform(fn($productPrice) => $productPrice
                // set relation to parent manually
                ->setRelation('priceListVersion', $resource)
                // set relation to currency manually
                ->setRelation('currency', $resource->currency)
                // set relation to product manually using already loaded products
                ->setRelation('product', $products->firstWhere('id', $productPrice->product_id))
                // set relation to variant manually using already loaded variants
                ->setRelation('variant', $products->firstWhere('id', $productPrice->product_id)
                    ->variants->firstWhere('id', $productPrice->variant_id))
            ));

        // show edit form
        return view('products-catalog::price_list_versions.edit', compact('resource',
            'price_lists',
            'products',
        ));
    }

    public function update(Request $request, Resource $resource) {
        // start a transaction
        DB::beginTransaction();

        // save resource
        if (!$resource->update( $request->input() ))
            // redirect with errors
            return back()->withInput()
                ->withErrors( $resource->errors() );

        // sync prices
        if (($redirect = $this->syncPrices($resource, $request->get('prices'))) !== true)
            // return redirection
            return $redirect;

        // confirm transaction
        DB::commit();

        // redirect to list
        return redirect()->route('backend.price_list_versions');
    }

    public function destroy(Request $request, Resource $resource) {
        // delete resource
        if (!$resource->delete())
            // redirect with errors
            return back()
                ->withErrors( $resource->errors() );

        // redirect to list
        return redirect()->route('backend.price_list_versions');
    }

    private function syncPrices(Resource $resource, array $prices) {
        // load  prices
        $resource->load([ 'prices' => fn($productPrice) => $productPrice
            // don't load prices with deleted products nor variants
            ->whereHas('product', fn($product) => $product->whereNull('deleted_at'))
            ->whereHas('variant', fn($variant) => $variant->whereNull('deleted_at'))
        ]);

        // foreach new/updated prices
        foreach (($prices = array_group( $prices )) as $price) {
            // ignore line if product wasn't specified
            if (!isset($price['product_id']) || !isset($price['price'])) continue;
            // load product
            $product = Product::find($price['product_id']);
            // load variant, if was specified
            $variant = isset($price['variant_id']) ? $product->variants->firstWhere('id', $price['variant_id']) : null;

            // find existing line
            $productPrice = $resource->prices->first(function($pPrice) use ($product, $variant) {
                return $pPrice->product_id == $product->id &&
                    $pPrice->variant_id == ($variant->id ?? null);
            // create a new price
            }) ?? ProductPrice::make([
                'price_list_version_id' => $resource->id,
                'product_id'            => $product->id,
                'variant_id'            => $variant->id ?? null,
            ]);

            // update line values
            $productPrice->fill([
                'list'  => $price['list'] ?? null,
                'price' => $price['price'] ?? 0,
                'limit' => $price['limit'] ?? null,
            ]);
            // save inventory line
            if (!$productPrice->save())
                return back()->withInput()
                    ->withErrors( $productPrice->errors() );
        }

        // find removed inventory prices
        foreach ($resource->prices as $price) {
            // deleted flag
            $deleted = true;
            // check against $request->prices
            foreach ($prices as $rLine) {
                // ignore empty prices
                if (!isset($rLine['product_id']) || !isset($rLine['price'])) continue;
                // check if line exists
                if ($price->product_id == $rLine['product_id'] &&
                    $price->variant_id == ($rLine['variant_id'] ?? null))
                    // change flag to keep line
                    $deleted = false;
            }
            // remove line if was deleted
            if ($deleted) $price->delete();
        }

        // return success
        return true;
    }

}
