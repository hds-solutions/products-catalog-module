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

            Column::make('label')
                ->title( __('products-catalog::option.label.0') ),

            Column::make('value_type')
                ->title( __('products-catalog::option.value_type.0') ),

            Column::computed('actions'),
        ];
    }

}
