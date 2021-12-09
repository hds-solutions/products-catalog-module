<?php

namespace HDSSolutions\Laravel\Http\Controllers;

use App\Http\Controllers\Controller;
use HDSSolutions\Laravel\DataTables\PriceListDataTable as DataTable;
use HDSSolutions\Laravel\Http\Request;
use HDSSolutions\Laravel\Models\PriceList as Resource;
use HDSSolutions\Laravel\Models\Option;

class PriceListController extends Controller {

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
        return $dataTable->render('products-catalog::price_lists.index', [
            'count'                 => Resource::count(),
            'show_company_selector' => !backend()->companyScoped(),
        ]);
    }

    public function create(Request $request) {
        // force company selection
        if (!backend()->companyScoped()) return view('backend::layouts.master', [ 'force_company_selector' => true ]);

        // show create form
        return view('products-catalog::price_lists.create');
    }

    public function store(Request $request) {
        // cast to boolean
        if ($request->has('is_purchase'))   $request->merge([ 'is_purchase' => filter_var($request->is_purchase, FILTER_VALIDATE_BOOLEAN) ]);
        if ($request->has('is_default'))    $request->merge([ 'is_default' => filter_var($request->is_default, FILTER_VALIDATE_BOOLEAN) ]);

        // create resource
        $resource = new Resource( $request->input() );

        // save resource
        if (!$resource->save())
            // redirect with errors
            return back()->withInput()
                ->withErrors( $resource->errors() );

        // check return type
        return $request->has('only-form') ?
            // redirect to popup callback
            view('backend::components.popup-callback', compact('resource')) :
            // redirect to resources list
            redirect()->route('backend.price_lists');
    }

    public function show(Request $request, Resource $resource) {
        // redirect to list
        return redirect()->route('backend.price_lists');
    }

    public function edit(Request $request, Resource $resource) {
        // show edit form
        return view('products-catalog::price_lists.edit', compact('resource'));
    }

    public function update(Request $request, Resource $resource) {
        // cast to boolean
        if ($request->has('is_purchase'))   $request->merge([ 'is_purchase' => filter_var($request->is_purchase, FILTER_VALIDATE_BOOLEAN) ]);
        if ($request->has('is_default'))    $request->merge([ 'is_default' => filter_var($request->is_default, FILTER_VALIDATE_BOOLEAN) ]);

        // save resource
        if (!$resource->update( $request->input() ))
            // redirect with errors
            return back()->withInput()
                ->withErrors( $resource->errors() );

        // redirect to list
        return redirect()->route('backend.price_lists');
    }

    public function destroy(Request $request, Resource $resource) {
        // delete resource
        if (!$resource->delete())
            // redirect with errors
            return back()
                ->withErrors( $resource->errors() );

        // redirect to list
        return redirect()->route('backend.price_lists');
    }

}
