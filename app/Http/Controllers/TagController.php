<?php

namespace HDSSolutions\Laravel\Http\Controllers;

use App\Http\Controllers\Controller;
use HDSSolutions\Laravel\DataTables\TagDataTable as DataTable;
use HDSSolutions\Laravel\Http\Request;
use HDSSolutions\Laravel\Models\Tag as Resource;

class TagController extends Controller {

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
        return $dataTable->render('products-catalog::tags.index', [
            'count'                 => Resource::count(),
            'show_company_selector' => !backend()->companyScoped(),
        ]);
    }

    public function create(Request $request) {
        // force company selection
        if (!backend()->companyScoped()) return view('backend::layouts.master', [ 'force_company_selector' => true ]);

        // show create form
        return view('products-catalog::tags.create');
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
            redirect()->route('backend.tags');
    }

    public function show(Request $request, Resource $resource) {
        // redirect to list
        return redirect()->route('backend.tags');
    }

    public function edit(Request $request, Resource $resource) {
        // show edit form
        return view('products-catalog::tags.edit', compact('resource'));
    }

    public function update(Request $request, Resource $resource) {
        // save resource
        if (!$resource->update( $request->input() ))
            // redirect with errors
            return back()->withInput()
                ->withErrors( $resource->errors() );

        // redirect to list
        return redirect()->route('backend.tags');
    }

    public function destroy(Request $request, Resource $resource) {
        // delete resource
        if (!$resource->delete())
            // redirect with errors
            return back()
                ->withErrors( $resource->errors() );

        // redirect to list
        return redirect()->route('backend.tags');
    }

}
