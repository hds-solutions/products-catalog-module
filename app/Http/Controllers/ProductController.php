<?php

namespace HDSSolutions\Finpar\Http\Controllers;

use App\Http\Controllers\Controller;
use HDSSolutions\Finpar\DataTables\ProductDataTable as DataTable;
use HDSSolutions\Finpar\Http\Request;
use HDSSolutions\Finpar\Models\Brand;
use HDSSolutions\Finpar\Models\Category;
use HDSSolutions\Finpar\Models\Currency;
use HDSSolutions\Finpar\Models\Family;
use HDSSolutions\Finpar\Models\File;
use HDSSolutions\Finpar\Models\Line;
use HDSSolutions\Finpar\Models\Product as Resource;
use HDSSolutions\Finpar\Models\Tag;
use HDSSolutions\Finpar\Models\Type;
use HDSSolutions\Finpar\Models\Warehouse;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller {

    public function __construct() {
        // check resource Policy
        $this->authorizeResource(Resource::class, 'resource');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, DataTable $dataTable) {
        // check only-form flag
        if ($request->has('only-form'))
            // redirect to popup callback
            return view('backend::components.popup-callback', [ 'resource' => new Resource ]);

        // load resources
        if ($request->ajax()) return $dataTable->ajax();

        // return view with dataTable
        return $dataTable->render('products-catalog::products.index', [ 'count' => Resource::count() ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        // load product catalog
        $brands = Brand::with([ 'models' => fn($query) => $query->ordered() ])
            ->ordered()->get();
        $families = Family::with([ 'subFamilies' => fn($query) => $query->ordered() ])
            ->ordered()->get();
        $lines = Line::with([ 'gamas' => fn($query) => $query->ordered() ])
            ->ordered()->get();
        // product types
        $types = Type::ordered()->get();
        // categories
        $categories = Category::ordered()->get();
        // load tags
        $tags = Tag::ordered()->get();
        // load images
        $images = File::images()->get();
        // load warehouses
        $warehouses = Warehouse::with([ 'locators' ])
            ->ordered()->get();
        // load currencies
        $currencies = Currency::ordered()->get();
        // show create form
        return view('products-catalog::products.create', compact(
            'brands', 'families', 'lines',
            'types', 'categories',
            'tags', 'images', 'warehouses', 'currencies'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        // start a transaction
        DB::beginTransaction();

        // cast giftcard to boolean
        if ($request->has('giftcard'))  $request->merge([ 'giftcard' => $request->giftcard == 'true' ]);
        if ($request->has('visible'))   $request->merge([ 'visible' => $request->visible == 'true' ]);

        // create resource
        $resource = new Resource( $request->input() );

        // save resource
        if (!$resource->save())
            // redirect with errors
            return back()
                ->withErrors( $resource->errors() )
                ->withInput();

        // save product images
        if (($redirect = $this->saveResourceImages($resource, $request)) !== true) return $redirect;

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

        // check return type
        return $request->has('only-form') ?
            // redirect to popup callback
            view('backend::components.popup-callback', compact('resource')) :
            // redirect to resources list
            redirect()->route('backend.products');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function show(Resource $resource) {
        // redirect to list
        return redirect()->route('backend.products');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function edit(Resource $resource) {
        // load product catalog
        $brands = Brand::with([ 'models' => function($query) { return $query->ordered(); } ])
            ->ordered()->get();
        $families = Family::with([ 'subFamilies' => function($query) { return $query->ordered(); } ])
            ->ordered()->get();
        $lines = Line::with([ 'gamas' => function($query) { return $query->ordered(); } ])
            ->ordered()->get();
        // product types
        $types = Type::ordered()->get();
        // categories
        $categories = Category::ordered()->get();
        // tags
        $tags = Tag::ordered()->get();
        // load images
        $images = File::images()->get();
        // load warehouses
        $warehouses = Warehouse::with([ 'locators' ])
            ->ordered()->get();
        // load currencies
        $currencies = Currency::ordered()->get();
        // load product images and offers
        $resource->load([
            'categories',
            'tags',
            'images',
            'locators',
            'prices',
        ]);
        // show edit form
        return view('products-catalog::products.edit', compact(
            'resource',
            'brands', 'families', 'lines',
            'types', 'categories',
            'tags', 'images', 'warehouses', 'currencies'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Resource $resource) {
        // start a transaction
        DB::beginTransaction();

        // cast to boolean
        if ($request->has('giftcard'))  $request->merge([ 'giftcard' => $request->giftcard == 'true' ]);
        if ($request->has('visible'))   $request->merge([ 'visible' => $request->visible == 'true' ]);

        // save resource
        if (!$resource->update( $request->input() ))
            // redirect with errors
            return $request->expectsJson() ?
                // return errors as json
                response()->json( $resource->errors() ) :
                // redirect with errors
                back()
                    ->withErrors( $resource->errors() )
                    ->withInput();

        // save product images
        if (($redirect = $this->saveResourceImages($resource, $request)) !== true) return $redirect;

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        // find resource
        $resource = Resource::findOrFail($id);
        // delete resource
        if (!$resource->delete())
            // redirect with errors
            return back();
        // redirect to list
        return redirect()->route('backend.products');
    }

    private function saveResourceImages(Resource $resource, Request $request) {
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
                    return back()
                        ->withErrors($image->errors())
                        ->withInput();
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
