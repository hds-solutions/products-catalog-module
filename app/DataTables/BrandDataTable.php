<?php

namespace HDSSolutions\Laravel\DataTables;

use HDSSolutions\Laravel\Models\Brand as Resource;
use Yajra\DataTables\Html\Column;

class BrandDataTable extends Base\DataTable {

    public function __construct() {
        parent::__construct(
            Resource::class,
            route('backend.brands'),
        );
    }

    protected function getColumns() {
        return [
            Column::computed('id')
                ->title( __('products-catalog::brand.id.0') )
                ->hidden(),

            Column::make('name')
                ->title( __('products-catalog::brand.name.0') ),

            Column::computed('actions'),
        ];
    }

}
