<?php

namespace HDSSolutions\Finpar\DataTables;

use HDSSolutions\Finpar\Models\Line as Resource;
use Yajra\DataTables\Html\Column;

class LineDataTable extends Base\DataTable {

    public function __construct() {
        parent::__construct(
            Resource::class,
            route('backend.lines'),
        );
    }

    protected function getColumns() {
        return [
            Column::computed('id')
                ->title( __('products-catalog::line.id.0') )
                ->hidden(),

            Column::make('name')
                ->title( __('products-catalog::line.name.0') ),

            Column::make('actions'),
        ];
    }

}
