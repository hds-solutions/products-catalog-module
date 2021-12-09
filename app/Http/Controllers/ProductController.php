<?php

namespace HDSSolutions\Laravel\Http\Controllers;

use App\Http\Controllers\Controller;
use HDSSolutions\Laravel\DataTables\ProductDataTable as DataTable;
use HDSSolutions\Laravel\DataTables\Modals\ProductsDataTable as SearchDataTable;
use HDSSolutions\Laravel\Http\Request;
use HDSSolutions\Laravel\Models\Brand;
use HDSSolutions\Laravel\Models\Category;
use HDSSolutions\Laravel\Models\Family;
use HDSSolutions\Laravel\Models\File;
use HDSSolutions\Laravel\Models\Line;
use HDSSolutions\Laravel\Models\Product as Resource;
use HDSSolutions\Laravel\Models\Tag;
use HDSSolutions\Laravel\Models\Type;
use HDSSolutions\Laravel\Models\Warehouse;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller {

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

        // load filters
        $types = Type::ordered()->get();
        $brands = Brand::with([
            'models' => fn($model) => $model->ordered(),
        ])->ordered()->get();
        $families = Family::with([
            'subFamilies' => fn($subFamily) => $subFamily->ordered(),
        ])->ordered()->get();
        $lines = Line::with([
            'gamas' => fn($gama) => $gama->ordered(),
        ])->ordered()->get();

        // return view with dataTable
        return $dataTable->render('products-catalog::products.index', compact(
            'types', 'brands', 'families', 'lines',
        ) + [
            'count'                 => Resource::count(),
            'show_company_selector' => !backend()->companyScoped(),
        ]);
    }

    public function search(Request $request, SearchDataTable $dataTable) {
        // load resources
        return $dataTable->ajax();
    }

    public function create(Request $request) {
        // force company selection
        if (!backend()->companyScoped()) return view('backend::layouts.master', [ 'force_company_selector' => true ]);

        // load product catalog
        $brands = Brand::with([
            'models' => fn($model) => $model->ordered(),
        ])->ordered()->get();
        $families = Family::with([
            'subFamilies' => fn($subFamily) => $subFamily->ordered(),
        ])->ordered()->get();
        $lines = Line::with([
            'gamas' => fn($gama) => $gama->ordered(),
        ])->ordered()->get();
        // product types
        $types = Type::ordered()->get();
        // categories
        $categories = Category::ordered()->get();
        // load tags
        $tags = Tag::ordered()->get();
        // load images
        $images = File::images()->get();
        // load warehouses
        $warehouses = Warehouse::with([
            'locators' => fn($locator) => $locator->ordered(),
        ])->ordered()->get();
        // load currencies
        $currencies = backend()->currencies();

        // show create form
        return view('products-catalog::products.create', compact(
            'brands', 'families', 'lines',
            'types', 'categories',
            'tags', 'images', 'warehouses', 'currencies',
        ));
    }

    public function store(Request $request) {
        // start a transaction
        DB::beginTransaction();

        // cast to boolean
        if ($request->has('giftcard'))  $request->merge([ 'giftcard' => filter_var($request->giftcard, FILTER_VALIDATE_BOOLEAN) ]);
        if ($request->has('visible'))   $request->merge([ 'visible' => filter_var($request->visible, FILTER_VALIDATE_BOOLEAN) ]);

        // create resource
        $resource = new Resource( $request->input() );

        // save resource
        if (!$resource->save())
            // redirect with errors
            return back()->withInput()
                ->withErrors( $resource->errors() );

        // save product images
        if (($redirect = $this->saveResourceImages($request, $resource)) !== true) return $redirect;

        // sync product categories
        if ($request->has('categories')) $resource->categories()->sync(
            // get categories as collection
            $categories = collect($request->get('categories'))
                // filter empty categories
                ->filter(fn($category) => $category !== null)
            );

        // sync product tags
        if ($request->has('tags')) $resource->tags()->sync(
            // get tags as collection
            $tags = collect($request->get('tags'))
                // filter empty tags
                ->filter(fn($tag) => $tag !== null)
            );

        // sync product locators
        if ($request->has('locators')) $resource->locators()->sync(
            // get locators as collection
            $locators = collect(array_group($request->get('locators')))
                // filter locator without currency set
                ->filter(fn($locator) => array_key_exists('locator_id', $locator) && $locator['locator_id'] !== null)
                // use locator_id as collection key
                ->keyBy('locator_id')
            );

        // // sync product prices
        // if ($request->has('prices')) $resource->prices()->sync(
        //     // get prices as collection
        //     $prices = collect(array_group($request->get('prices')))
        //         // filter price without currency set
        //         ->filter(fn($price) => array_key_exists('currency_id', $price) && $price['currency_id'] !== null)
        //         // use currency_id as collection key
        //         ->keyBy('currency_id')
        //     );

        // confirm transaction
        DB::commit();

        // check return type
        return $request->has('only-form') ?
            // redirect to popup callback
            view('backend::components.popup-callback', compact('resource')) :
            // redirect to resources list
            redirect()->route('backend.products');
    }

    public function show(Request $request, Resource $resource) {
        // redirect to list
        return redirect()->route('backend.products');
    }

    public function edit(Request $request, Resource $resource) {
        // load product catalog
        $brands = Brand::with([
            'models' => fn($model) => $model->ordered(),
        ])->ordered()->get();
        $families = Family::with([
            'subFamilies' => fn($subFamily) => $subFamily->ordered(),
        ])->ordered()->get();
        $lines = Line::with([
            'gamas' => fn($gama) => $gama->ordered(),
        ])->ordered()->get();
        // product types
        $types = Type::ordered()->get();
        // categories
        $categories = Category::ordered()->get();
        // tags
        $tags = Tag::ordered()->get();
        // load images
        $images = File::images()->get();
        // load warehouses
        $warehouses = Warehouse::with([
            'locators' => fn($locator) => $locator->ordered(),
        ])->ordered()->get();

        // load product images and offers
        $resource->load([
            'categories',
            'tags',
            'images',
            'locators',
            // 'prices',
        ]);

        // show edit form
        return view('products-catalog::products.edit', compact(
            'resource',
            'brands', 'families', 'lines',
            'types', 'categories',
            'tags', 'images', 'warehouses',
        ));
    }

    public function update(Request $request, Resource $resource) {
        // start a transaction
        DB::beginTransaction();

        // cast to boolean
        if ($request->has('giftcard'))  $request->merge([ 'giftcard' => filter_var($request->giftcard, FILTER_VALIDATE_BOOLEAN) ]);
        if ($request->has('visible'))  $request->merge([ 'visible' => filter_var($request->visible, FILTER_VALIDATE_BOOLEAN) ]);

        // save resource
        if (!$resource->update( $request->input() ))
            // redirect with errors
            return $request->expectsJson() ?
                // return errors as json
                response()->json( $resource->errors() ) :
                // redirect with errors
                back()->withInput()
                    ->withErrors( $resource->errors() );

        // save product images
        if (($redirect = $this->saveResourceImages($request, $resource)) !== true) return $redirect;

        // sync product categories
        if ($request->has('categories')) $resource->categories()->sync(
            // get categories as collection
            $categories = collect($request->get('categories'))
                // filter empty categories
                ->filter(fn($category) => $category !== null)
            );

        // sync product tags
        if ($request->has('tags')) $resource->tags()->sync(
            // get tags as collection
            $tags = collect($request->get('tags'))
                // filter empty tags
                ->filter(fn($tag) => $tag !== null)
            );

        // sync product locators
        if ($request->has('locators')) $resource->locators()->sync(
            // get locators as collection
            $locators = collect(array_group($request->get('locators')))
                // filter locator without currency set
                ->filter(fn($locator) => array_key_exists('locator_id', $locator) && $locator['locator_id'] !== null)
                // use locator_id as collection key
                ->keyBy('locator_id')
            );

        // sync product prices
        if ($request->has('prices')) $resource->prices()->sync(
            // get prices as collection
            $prices = collect(array_group($request->get('prices')))
                // filter price without currency set
                ->filter(fn($price) => array_key_exists('currency_id', $price) && $price['currency_id'] !== null)
                // use currency_id as collection key
                ->keyBy('currency_id')
            );

        // confirm transaction
        DB::commit();

        // check response type
        return $request->expectsJson() ?
            // return resource on JSON request
            response()->json( $resource->refresh() ) :
            // redirect to list
            redirect()->route('backend.products');
    }

    public function destroy(Request $request, Resource $resource) {
        // delete resource
        if (!$resource->delete())
            // redirect with errors
            return back()
                ->withErrors( $resource->errors() );

        // redirect to list
        return redirect()->route('backend.products');
    }

    private function saveResourceImages(Request $request, Resource $resource) {
        // check new uploaded image
        if ($request->hasFile('images')) {
            // foreach uploaded files
            $images = [];
            foreach ($request->file('images') as $image) {
                // upload image
                $image = File::upload($request, $image, $this);
                // save resource
                if (!$image->save())
                    // redirect with errors
                    return back()->withInput()
                        ->withErrors( $image->errors() );

                // append to images
                $images[] = $image->id;
            }
            // append to request
            $request->merge([ 'images' => array_merge($request->get('images') ?? [], $images) ]);
        }

        // sync images
        if ($request->has('images')) $resource->images()->sync( $request->get('images') ?? [] );

        //
        return true;
    }

}
