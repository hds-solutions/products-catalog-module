<?php

namespace HDSSolutions\Laravel\Jobs;

use HDSSolutions\Laravel\Imports\ProductsImporter as Importer;
use HDSSolutions\Laravel\Models\File;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ProductsImportJob extends BaseJob  {

    public function __construct(
        private File $import,
        private int $sheet,
        private Collection $matches,
        private Collection $customs,
    ) {
        parent::__construct();
    }

    protected function execute() {
        logger('Import of Excel '.$this->import->name.' to products started');

        // instanciate importer
        $importer = new Importer($this->sheet, $this->matches, $this->customs);

        // start a transaction
        DB::beginTransaction();
        // import document to model
        Excel::import($importer, $this->import->file());
        // confirm transaction
        DB::commit();

        // delete imported file
        $this->import->delete();
    }
}
