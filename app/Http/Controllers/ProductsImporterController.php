<?php

namespace HDSSolutions\Laravel\Http\Controllers;

use App\Http\Controllers\Controller;
use HDSSolutions\Laravel\Helpers\SheetReader;
use HDSSolutions\Laravel\Http\Request;
use HDSSolutions\Laravel\Jobs\ProductsImportJob;
use HDSSolutions\Laravel\Models\File;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class ProductsImporterController extends Controller {

    public function index(Request $request) {
        // show view to match headers
        return view('products-catalog::products.import.index');
    }

    public function store(Request $request) {
        // check if import file wasn't set
        if (!$request->hasFile('import') ||
            // check if file can't be loaded
            ($spreadsheet = $request->file('import')) === null)
            // return error
            return back()
                ->withErrors([ __('products-catalog::products.import.file-error') ]);

        // save file to disk
        if (!($file = File::upload( $request, $spreadsheet, $this, false ))->save())
            // redirect back with errors
            return back()->withInput()
                ->withErrors( $file->errors() );

        // redirect to import headers configuration
        return redirect()->route('backend.products.import.headers', $file);
    }

    public function headers(Request $request, File $import) {
        // get all headers from document grouped by sheet
        $sheets = $this->sheets($import);

        // show view to match headers
        return view('products-catalog::products.import.headers', compact('import', 'sheets'));
    }

    public function process(Request $request, File $import) {
        // remove all NULL, FALSE and Empty strings, leaving 0 (zero) values
        $headers = array_filter($request->input('headers'), 'strlen');

        // check if selected headers are different from each other
        if (count( array_unique($headers) ) !== count($headers))
            // return back with errors
            return back()->withInput()
                ->withErrors([ 'headers' => 'Selected headers must be different from each other' ]);

        // get all headers from document grouped by sheet
        $sheets = $this->sheets($import);

        // build matches
        $matches = collect();
        foreach ($headers as $field => $header)
            // add match for field from selected header
            $matches->put($field, $sheets->values()->get( $request->sheet )->get($header));

        // build custom matches
        $customs = collect();
        collect( array_group( $request->input('customs') ) )
            ->map(function($custom) use ($request, $sheets, $customs) {
                // ignore empty
                if ($custom['field'] === null || $custom['header'] === null) return;
                // create container
                if (!$customs->has($custom['field'])) $customs->put($custom['field'], collect());
                // get field matches container
                $customs->put($custom['field'], $customs->get($custom['field'])
                    // add match for custom field from selected header
                    ->push($sheets->values()->get( $request->sheet )->get($custom['header']))
                );
            });

        // dispatch ProductsImport Job
        ProductsImportJob::dispatch($import, $request->sheet, $matches, $customs);

        // redirect to products list
        return redirect()->route('backend.products');
    }

    private function sheets(File $resource):Collection {
        // load excel data
        Excel::import($reader = new SheetReader, $resource->file());

        // get all headers from document grouped by sheet
        $sheets = collect();
        (new HeadingRowImport)->toCollection( $resource->file() )
            // save headers from each sheet
            ->each(fn($sheet, $idx) => $sheets->put($reader->getSheetTitle($idx), $sheet->flatten()));

        // return sheets with headers
        return $sheets;
    }

}
