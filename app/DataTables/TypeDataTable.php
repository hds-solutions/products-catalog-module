<?php

namespace HDSSolutions\Laravel\DataTables;

use HDSSolutions\Laravel\Models\Type as Resource;
use Yajra\DataTables\Html\Column;

class TypeDataTable extends Base\DataTable {

    public function __construct() {
        parent::__construct(
            Resource::class,
            route('backend.types'),
        );
    }

    protected function getColumns() {
        return [
            Column::computed('id')
                ->title( __('products-catalog::type.id.0') )
                ->hidden(),

            Column::make('name')
                ->title( __('products-catalog::type.name.0') ),

            Column::computed('actions'),
        ];
    }

}
