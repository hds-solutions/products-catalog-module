<?php

namespace HDSSolutions\Laravel\Http\Controllers;

use App\Http\Controllers\Controller;
use HDSSolutions\Laravel\DataTables\LineDataTable as DataTable;
use HDSSolutions\Laravel\Http\Request;
use HDSSolutions\Laravel\Models\Line as Resource;
use HDSSolutions\Laravel\Models\Option;

class LineController extends Controller {

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
        return $dataTable->render('products-catalog::lines.index', [
            'count'                 => Resource::count(),
            'show_company_selector' => !backend()->companyScoped(),
        ]);
    }

    public function create(Request $request) {
        // force company selection
        if (!backend()->companyScoped()) return view('backend::layouts.master', [ 'force_company_selector' => true ]);

        // get options
        $options = Option::ordered()->get();

        // show create form
        return view('products-catalog::lines.create', compact('options'));
    }

    public function store(Request $request) {
        // create resource
        $resource = new Resource( $request->input() );

        // save resource
        if (!$resource->save())
            // redirect with errors
            return back()->withInput()
                ->withErrors( $resource->errors() );

        // sync options
        if ($request->has('options')) $resource->options()->sync(
            // get options as collection
            $options = collect($request->get('options'))
                // filter empty options
                ->filter(fn($option) => $option !== null)
            );

        // check return type
        return $request->has('only-form') ?
            // redirect to popup callback
            view('backend::components.popup-callback', compact('resource')) :
            // redirect to resources list
            redirect()->route('backend.lines');
    }

    public function show(Request $request, Resource $line) {
        // redirect to list
        return redirect()->route('backend.lines');
    }

    public function edit(Request $request, Resource $resource) {
        // get options
        $options = Option::ordered()->get();

        // show edit form
        return view('products-catalog::lines.edit', compact('options', 'resource'));
    }

    public function update(Request $request, Resource $resource) {
        // save resource
        if (!$resource->update( $request->input() ))
            // redirect with errors
            return back()->withInput()
                ->withErrors( $resource->errors() );

        // sync options
        if ($request->has('options')) $resource->options()->sync(
            // get options as collection
            $options = collect($request->get('options'))
                // filter empty options
                ->filter(fn($option) => $option !== null)
            );

        // redirect to list
        return redirect()->route('backend.lines');
    }

    public function destroy(Request $request, Resource $resource) {
        // delete resource
        if (!$resource->delete())
            // redirect with errors
            return back()
                ->withErrors( $resource->errors() );

        // redirect to list
        return redirect()->route('backend.lines');
    }

}
