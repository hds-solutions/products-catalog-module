<?php

namespace HDSSolutions\Finpar\Http\Controllers;

use App\Http\Controllers\Controller;
use HDSSolutions\Finpar\DataTables\BrandDataTable as DataTable;
use HDSSolutions\Finpar\Http\Request;
use HDSSolutions\Finpar\Models\Brand as Resource;
use HDSSolutions\Finpar\Models\File;

class BrandController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, DataTable $dataTable) {
        // load resources
        if ($request->ajax()) return $dataTable->ajax();
        // return view with dataTable
        return $dataTable->render('products-catalog::brands.index', [ 'count' => Resource::count() ]);

        // fetch all objects
        $resources = Brand::with([ 'logo' ])->ordered()->get();
        // show a list of objects
        return view('brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        // load images
        $images = File::images()->get();
        // show create form
        return view('products-catalog::brands.create', compact('images'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        // cast show_home to boolean
        $request->merge([ 'show_home' => $request->show_home == 'on' ]);

        // create resource
        $resource = new Resource( $request->input() );

        // check new uploaded image
        if ($request->hasFile('image')) {
            // upload image
            $image = File::upload($request, $request->file('image'), $this);
            // save resource
            if (!$image->save())
                // redirect with errors
                return back()
                    ->withErrors($image->errors())
                    ->withInput();
            // set uploaded image into resource
            $resource->logo_id = $image->id;
        }

        // save resource
        if (!$resource->save())
            // redirect with errors
            return back()
                ->withErrors( $resource->errors() )
                ->withInput();

        // redirect to list
        return redirect()->route('backend.brands');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function show(Resource $resource) {
        // redirect to list
        return redirect()->route('backend.brands');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function edit(Resource $resource) {
        // load images
        $images = File::images()->get();
        // show edit form
        return view('products-catalog::brands.edit', compact('brand', 'images'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        // cast show_home to boolean
        $request->merge([ 'show_home' => $request->show_home == 'on' ]);

        // find resource
        $resource = Resource::findOrFail($id);

        // check new uploaded image
        if ($request->hasFile('image')) {
            // upload image
            $image = File::upload($request, $request->file('image'), $this);
            // save resource
            if (!$image->save())
                // redirect with errors
                return back()
                    ->withErrors($image->errors())
                    ->withInput();
            // set uploaded image into request
            $request->merge([ 'logo_id' => $image->id ]);
        }

        // save resource
        if (!$resource->update( $request->input() ))
            // redirect with errors
            return back()
                ->withErrors( $resource->errors() )
                ->withInput();

        // redirect to list
        return redirect()->route('backend.brands');
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
        return redirect()->route('backend.brands');
    }

}
