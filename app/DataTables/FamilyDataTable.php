<?php

namespace HDSSolutions\Laravel\DataTables;

use HDSSolutions\Laravel\Models\Family as Resource;
use Yajra\DataTables\Html\Column;

class FamilyDataTable extends Base\DataTable {

    public function __construct() {
        parent::__construct(
            Resource::class,
            route('backend.families'),
        );
    }

    protected function getColumns() {
        return [
            Column::computed('id')
                ->title( __('products-catalog::family.id.0') )
                ->hidden(),

            Column::make('name')
                ->title( __('products-catalog::family.name.0') ),

            Column::make('actions'),
        ];
    }

}
