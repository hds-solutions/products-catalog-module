<?php

namespace HDSSolutions\Laravel\Http\Controllers;

use App\Http\Controllers\Controller;
use HDSSolutions\Laravel\DataTables\SubFamilyDataTable as DataTable;
use HDSSolutions\Laravel\Http\Request;
use HDSSolutions\Laravel\Models\Family;
use HDSSolutions\Laravel\Models\SubFamily as Resource;

class SubFamilyController extends Controller {

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

        // get available families
        $families = Family::ordered()->get();

        // return view with dataTable
        return $dataTable->render('products-catalog::sub_families.index', compact('families') + [
            'count'                 => Resource::count(),
            'show_company_selector' => !backend()->companyScoped(),
        ]);
    }

    public function create(Request $request) {
        // force company selection
        if (!backend()->companyScoped()) return view('backend::layouts.master', [ 'force_company_selector' => true ]);

        // load families
        $families = Family::ordered()->get();

        // show create form
        return view('products-catalog::sub_families.create', compact('families'));
    }

    public function store(Request $request) {
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
            redirect()->route('backend.sub_families');
    }

    public function show(Request $request, Resource $resource) {
        // redirect to list
        return redirect()->route('backend.sub_families');
    }

    public function edit(Request $request, Resource $resource) {
        // load lines
        $lines = Family::ordered()->get();

        // show edit form
        return view('products-catalog::sub_families.edit', compact('resource', 'lines'));
    }

    public function update(Request $request, Resource $resource) {
        // save resource
        if (!$resource->update( $request->input() ))
            // redirect with errors
            return back()->withInput()
                ->withErrors( $resource->errors() );

        // redirect to list
        return redirect()->route('backend.sub_families');
    }

    public function destroy(Request $request, Resource $resource) {
        // delete resource
        if (!$resource->delete())
            // redirect with errors
            return back()
                ->withErrors( $resource->errors() );

        // redirect to list
        return redirect()->route('backend.sub_families');
    }

}
