<?php

namespace HDSSolutions\Laravel\DataTables;

use HDSSolutions\Laravel\Models\Option as Resource;
use Yajra\DataTables\Html\Column;

class OptionDataTable extends Base\DataTable {

    public function __construct() {
        parent::__construct(
            Resource::class,
            route('backend.options'),
        );
    }

    protected function getColumns() {
        return [
            Column::computed('id')
                ->title( __('products-catalog::option.id.0') )
                ->hidden(),

            Column::make('name')
                ->title( __('products-catalog::option.name.0') ),

            Column::make('actions'),
        ];
    }

}
