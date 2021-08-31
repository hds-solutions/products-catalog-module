<?php

namespace HDSSolutions\Laravel\Http\Controllers;

use App\Http\Controllers\Controller;
use HDSSolutions\Laravel\DataTables\GamaDataTable as DataTable;
use HDSSolutions\Laravel\Http\Request;
use HDSSolutions\Laravel\Models\Line;
use HDSSolutions\Laravel\Models\Gama as Resource;

class GamaController extends Controller {

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

        // get available lines
        $lines = Line::ordered()->get();

        // return view with dataTable
        return $dataTable->render('products-catalog::gamas.index', compact('lines') + [
            'count'                 => Resource::count(),
            'show_company_selector' => !backend()->companyScoped(),
        ]);
    }

    public function create(Request $request) {
        // force company selection
        if (!backend()->companyScoped()) return view('backend::layouts.master', [ 'force_company_selector' => true ]);

        // load lines
        $lines = Line::ordered()->get();

        // show create form
        return view('products-catalog::gamas.create', compact('lines'));
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
            redirect()->route('backend.gamas');
    }

    public function show(Request $request, Resource $resource) {
        // redirect to list
        return redirect()->route('backend.gamas');
    }

    public function edit(Request $request, Resource $resource) {
        // load lines
        $lines = Line::ordered()->get();
        // show edit form
        return view('products-catalog::gamas.edit', compact('resource', 'lines'));
    }

    public function update(Request $request, Resource $resource) {
        // save resource
        if (!$resource->update( $request->input() ))
            // redirect with errors
            return back()->withInput()
                ->withErrors( $resource->errors() );

        // redirect to list
        return redirect()->route('backend.gamas');
    }

    public function destroy(Request $request, Resource $resource) {
        // delete resource
        if (!$resource->delete())
            // redirect with errors
            return back()
                ->withErrors( $resource->errors() );

        // redirect to list
        return redirect()->route('backend.gamas');
    }

}
