<?php

namespace HDSSolutions\Finpar\Http\Controllers;

use App\Http\Controllers\Controller;
use HDSSolutions\Finpar\DataTables\VariantDataTable as DataTable;
use HDSSolutions\Finpar\Http\Request;
use HDSSolutions\Finpar\Models\Product;
use HDSSolutions\Finpar\Models\Variant as Resource;
use Illuminate\Support\Facades\DB;

class VariantController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, DataTable $dataTable) {
        // load resources
        if ($request->ajax()) return $dataTable->ajax();
        // return view with dataTable
        return $dataTable->render('products-catalog::variants.index', [ 'count' => Resource::count() ]);

        // fetch all objects
        $resources = Variant::with([
            'product.offers',
            'offers',
            'images',
            'values.option',
            'values.option_value',
            'storages',
        ])->ordered()->get();
        // filter by product
        if ($request->has('product_id')) $resources = $resources->where('product_id', $request->get('product_id'));
        // show a list of objects
        return view('variants.index', compact('variants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        // get products
        $products = Product::with([
            'type.options.values',
            'family.options.values',
            'line.options.values',
            'images',
        ])->ordered()->get();
        // get images from products
        $images = $products->pluck('images')->flatten();

        // get available options
        $options = $this->getAvailableOptions( $products );

        // TODO: warehouses
        $warehouses = collect();
        // $warehouses = Warehouse::with([ 'locators' ])
        //     ->ordered()->get();

        // show create form
        return view('products-catalog::variants.create', compact(
            'products', 'images',
            'options',
            'warehouses',
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

        // create resource
        $resource = new Resource( $request->input() );

        // // TODO: check if variant doesn't have price
        // if ($resource->price == null &&
        //     $resource->product->price == null)
        //     // return with errors
        //     return back()
        //         ->withInput()
        //         ->withErrors([ 'Variant price not specified' ]);

        // save resource
        if (!$resource->save())
            // redirect with errors
            return back()
                ->withErrors( $resource->errors() )
                ->withInput();

        // save Variant option values
        if (($res = $this->saveOptionValues($request, $resource)) !== true) return $res;

        // sync variant images
        if ($request->has('images')) $resource->images()->sync( $request->get('images') ?? [] );

        // // TODO: sync product locators
        // if ($resource->has('locators')) $resource->locators()
        //     ->sync( array_map(function() use ($resource) {
        //         // append product_id
        //         return [ 'product_id' => $resource->product_id ];
        //     // use locator_id's as keys
        //     }, array_flip( $request->get('locators') ?? [] )) );

        // confirm transaction
        DB::commit();

        // redirect to list
        return redirect()->route('backend.variants');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function show(Resource $resource) {
        // redirect to list
        return redirect()->route('backend.variants');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function edit(Resource $resource) {
        // load variant images
        $resource->load([ 'product', 'images', 'values' ]);

        // get products
        $products = Product::with([
            'type.options.values',
            'family.options.values',
            'line.options.values',
            'images',
        ])->ordered()->get();
        // load images
        $images = $products->pluck('images')->flatten();

        // get available options
        $options = $this->getAvailableOptions( $products );

        // warehouses
        $warehouses = collect();
        // $warehouses = Warehouse::with([ 'locators' ])
        //     ->ordered()->get();

        // show edit form
        return view('products-catalog::variants.edit', compact(
            'resource',
            'products', 'images',
            'options',
            'warehouses',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        // start a transaction
        DB::beginTransaction();

        // find resource
        $resource = Resource::findOrFail($id);

        // save resource
        if (!$resource->update( $request->input() ))
            // redirect with errors
            return back()
                ->withErrors( $resource->errors() )
                ->withInput();

        // save Variant option values
        if (($res = $this->saveOptionValues($request, $resource)) !== true) return $res;

        // sync product images
        if ($resource->has('images')) $resource->images()->sync( $request->get('images') );

        // // TODO: sync product locators
        // if ($resource->has('locators')) $resource->locators()
        //     ->sync( array_map(function() use ($resource) {
        //         // append product_id
        //         return [ 'product_id' => $resource->product_id ];
        //     // use locator_id's as keys
        //     }, array_flip( $request->get('locators') ?? [] )) );

        // confirm transaction
        DB::commit();

        // check response type
        return $request->expectsJson() ?
            // return resource on JSON request
            response()->json( $resource->refresh() ) :
            // redirect to list
            redirect()->route('backend.variants');
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
            return redirect()->back();
        // redirect to list
        return redirect()->route('backend.variants');
    }

    private function getAvailableOptions($products) {
        // get product types from products
        $types = $products->pluck('type', 'type_id')
            ->filter(function($type) { return !is_null($type); });
        // get product families from products
        $families = $products->pluck('family', 'family_id')
            ->filter(function($family) { return !is_null($family); });
        // get product lines from products
        $lines = $products->pluck('line', 'line_id')
            ->filter(function($line) { return !is_null($line); });

        // build a collection to return
        $options = collect();
        // foreach each relation
        foreach([ 'types', 'families', 'lines' ] as $relation)
            // get relation options
            foreach ($$relation->pluck('options', 'id') as $relation_id => $relation_options) {
                //
                foreach ($relation_options as $option) {
                    // save option to collection
                    if (!$options->has( $option->id )) $options->put( $option->id, $option );
                    // get saved option on collection
                    $option = $options->get( $option->id );
                    // attach relation collection on option
                    if ($option->$relation === null) $option->setRelation($relation, collect());
                    // push relation resource on collection
                    if (!$option->$relation->has( $relation_id )) $option->$relation->push( $$relation->get( $relation_id ) );
                }
            }

        // return available options
        return $options;
    }

    private function saveOptionValues(Request $request, Resource $resource) {
        // options to keep
        $options = collect();
        // validation errors
        $errors = collect();

        // foreach each relation
        foreach ([ 'type', 'family', 'line' ] as $relation) {
            // check if relation has options
            if (!$resource->product->$relation || !$resource->product->$relation->options->count()) continue;

            // foreach relation options
            foreach ($resource->product->$relation->options as $option) {
                // check if value for option wasn't specified
                if (!($value = optional($request->get('option_value_id'))[ $option->id ])) {
                    // save error
                    $errors->push( 'No value was specified for field '.$option->name );
                    // exit current relation loop
                    continue;
                }

                // check if option has already saved
                if (!$options->has( $option->id ))
                    // save value for option
                    $options->put($option->id, $value);

            }
        }

        // return back with errors
        if ($errors->count()) return back()
            ->withInput()
            ->withErrors( $errors );

        // update existing values
        foreach ($resource->values as $value) {
            // check if value was deleted
            if (!$options->has($value->option_id)) {
                // delete VariantValue
                $value->delete();
                continue;
            }

            // check if value was updated
            if ($value->option_value_id !== $options[$value->option_id]) {
                // update value
                $value->update([ 'option_value_id' => $options[$value->option_id] ]);
                // remove from collection
                $options->forget( $value->option_id );
            }
        }

        // create new variant values
        foreach ($options as $option_id => $value) {
            // create Variant Value
            $value = VariantValue::create([
                'variant_id'        => $resource->id,
                'option_id'         => $option_id,
                'option_value_id'   => $value,
            ]);
            // check for errors
            if (count($value->errors()) > 0)
                // return errors
                return back()
                    ->withErrors( $value->errors() )
                    ->withInput();
        }

        // return true
        return true;
    }

}
