<?php

namespace HDSSolutions\Finpar\Http\Controllers;

use App\Http\Controllers\Controller;
use HDSSolutions\Finpar\DataTables\OptionDataTable as DataTable;
use HDSSolutions\Finpar\Http\Request;
use HDSSolutions\Finpar\Models\Option as Resource;
use HDSSolutions\Finpar\Models\OptionValue as ResourceValue;
use Illuminate\Support\Facades\DB;

class OptionController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, DataTable $dataTable) {
        // load resources
        if ($request->ajax()) return $dataTable->ajax();
        // return view with dataTable
        return $dataTable->render('products-catalog::options.index', [ 'count' => Resource::count() ]);

        // fetch all objects
        $resources = Option::ordered()->get();
        // show a list of objects
        return view('options.index', compact('options'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        // show create form
        return view('products-catalog::options.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        // cast show to boolean
        if ($request->has('show'))  $request->merge([ 'show' => $request->show == 'true' ]);

        // start a transaction
        DB::beginTransaction();

        // create resource
        $resource = new Resource( $request->input() );

        // save resource
        if (!$resource->save())
            // redirect with errors
            return back()
                ->withErrors( $resource->errors() )
                ->withInput();

        // save option values
        $this->saveResourceValues($request, $resource);

        // confirm transaction
        DB::commit();

        // redirect to list
        return redirect()->route('backend.options');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function show(Resource $resource) {
        // redirect to list
        return redirect()->route('backend.options');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function edit(Resource $resource) {
        // show edit form
        return view('products-catalog::options.edit', compact('resource'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        // cast show to boolean
        if ($request->has('show'))  $request->merge([ 'show' => $request->show == 'true' ]);

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

        // save option values
        $this->saveResourceValues($request, $resource);

        // confirm transaction
        DB::commit();

        // redirect to list
        return redirect()->route('backend.options');
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
        return redirect()->route('backend.options');
    }

    private function saveResourceValues(Request $request, Resource $resource) {

        // build option values
        $resource_values = [];
        foreach ($request->get('values')['id'] as $idx => $id) {
            // append to option values
            $resource_values[] = [
                'id'    => $id,
                'value' => $request->get('values')['value'][$idx],
                'extra' => $request->get('values')['extra'][$idx],
            ];
        }

        // remove deleted option values
        $resource->values()->whereIn('id', array_diff(
            // original option values
            $resource->values->pluck('id')->toArray(),
            // option values from request
            $request->get('values')['id'],
        ))->delete();

        // foreach option values
        foreach ($resource_values as $resource_value) {
            // check for new option value
            if ($resource_value['id'] === 'new') {
                // ignore if empty
                if (trim($resource_value['value']) === '') continue;
                // create new option value
                ResourceValue::create([
                    'option_id' => $resource->id,
                    'value'     => $resource_value['value'],
                    'extra'     => $resource_value['extra'],
                ]);
            } else {
                // find option value
                $value = ResourceValue::findOrFail($resource_value['id']);
                // update data
                $value->update([
                    'value'     => $resource_value['value'],
                    'extra'     => $resource_value['extra'],
                ]);
            }
        }

    }

}
