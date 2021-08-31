<?php

namespace HDSSolutions\Laravel\Http\Controllers;

use App\Http\Controllers\Controller;
use HDSSolutions\Laravel\DataTables\BrandDataTable as DataTable;
use HDSSolutions\Laravel\Http\Request;
use HDSSolutions\Laravel\Models\Brand as Resource;
use HDSSolutions\Laravel\Models\File;

class BrandController extends Controller {

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
        return $dataTable->render('products-catalog::brands.index', [
            'count'                 => Resource::count(),
            'show_company_selector' => !backend()->companyScoped(),
        ]);
    }

    public function create(Request $request) {
        // force company selection
        if (!backend()->companyScoped()) return view('backend::layouts.master', [ 'force_company_selector' => true ]);

        // load images
        $images = File::images()->get();
        // show create form
        return view('products-catalog::brands.create', compact('images'));
    }

    public function store(Request $request) {
        // cast show_home to boolean
        if ($request->has('show_home')) $request->merge([ 'show_home' => filter_var($request->show_home, FILTER_VALIDATE_BOOLEAN) ]);

        // create resource
        $resource = new Resource( $request->input() );

        // check new uploaded image
        if ($request->hasFile('image')) {
            // upload image
            $image = File::upload($request, $request->file('image'), $this);
            // save resource
            if (!$image->save())
                // redirect with errors
                return back()->withInput()
                    ->withErrors( $image->errors() );

            // set uploaded image into resource
            $resource->logo_id = $image->id;
        }

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
            redirect()->route('backend.brands');
    }

    public function show(Request $request, Resource $resource) {
        // redirect to list
        return redirect()->route('backend.brands');
    }

    public function edit(Request $request, Resource $resource) {
        // load images
        $images = File::images()->get();
        // show edit form
        return view('products-catalog::brands.edit', compact('resource', 'images'));
    }

    public function update(Request $request, Resource $resource) {
        // cast show_home to boolean
        if ($request->has('show_home')) $request->merge([ 'show_home' => filter_var($request->show_home, FILTER_VALIDATE_BOOLEAN) ]);

        // check new uploaded image
        if ($request->hasFile('image')) {
            // upload image
            $image = File::upload($request, $request->file('image'), $this);
            // save resource
            if (!$image->save())
                // redirect with errors
                return back()->withInput()
                    ->withErrors( $image->errors() );

            // set uploaded image into request
            $request->merge([ 'logo_id' => $image->id ]);
        }

        // save resource
        if (!$resource->update( $request->input() ))
            // redirect with errors
            return back()->withInput()
                ->withErrors( $resource->errors() );

        // redirect to list
        return redirect()->route('backend.brands');
    }

    public function destroy(Request $request, Resource $resource) {
        // delete resource
        if (!$resource->delete())
            // redirect with errors
            return back()
                ->withErrors( $resource->errors() );

        // redirect to list
        return redirect()->route('backend.brands');
    }

}
