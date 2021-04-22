<?php

namespace HDSSolutions\Finpar\Jobs;

use HDSSolutions\Finpar\Imports\ProductsImporter as Importer;
use HDSSolutions\Finpar\Models\File;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ProductsImportJob extends BaseJob {

    public function __construct(
        private File $import,
        private Collection $matches,
        private Collection $customs,
        private int $sheet,
    ) {
        parent::__construct();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    protected function execute() {
        logger('Import of Excel '.$this->import->name.' to products started');
        // instanciate importer
        $importer = new Importer($this->matches, $this->customs, $this->sheet);

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
