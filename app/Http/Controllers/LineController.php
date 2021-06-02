<?php

namespace HDSSolutions\Finpar\Http\Controllers;

use App\Http\Controllers\Controller;
use HDSSolutions\Finpar\DataTables\LineDataTable as DataTable;
use HDSSolutions\Finpar\Http\Request;
use HDSSolutions\Finpar\Models\Line as Resource;
use HDSSolutions\Finpar\Models\Option;

class LineController extends Controller {

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
        return $dataTable->render('products-catalog::lines.index', [ 'count' => Resource::count() ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        // get options
        $options = Option::ordered()->get();
        // show create form
        return view('products-catalog::lines.create', compact('options'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        // create resource
        $resource = new Resource( $request->input() );

        // save resource
        if (!$resource->save())
            // redirect with errors
            return back()
                ->withErrors( $resource->errors() )
                ->withInput();

        // sync options
        $resource->options()->sync($request->options);

        // check return type
        return $request->has('only-form') ?
            // redirect to popup callback
            view('backend::components.popup-callback', compact('resource')) :
            // redirect to resources list
            redirect()->route('backend.lines');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Resource  $line
     * @return \Illuminate\Http\Response
     */
    public function show(Resource $line) {
        // redirect to list
        return redirect()->route('backend.lines');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Resource  $line
     * @return \Illuminate\Http\Response
     */
    public function edit(Resource $line) {
        // get options
        $options = Option::ordered()->get();
        // show edit form
        return view('products-catalog::lines.edit', compact('options', 'line'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Resource  $line
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        // find resource
        $resource = Resource::findOrFail($id);

        // save resource
        if (!$resource->update( $request->input() ))
            // redirect with errors
            return back()
                ->withErrors( $resource->errors() )
                ->withInput();

        // sync options
        $resource->options()->sync($request->options);

        // redirect to list
        return redirect()->route('backend.lines');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Resource  $line
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
        return redirect()->route('backend.lines');
    }

}
