<?php

namespace HDSSolutions\Laravel\DataTables;

use HDSSolutions\Laravel\Models\Tag as Resource;
use Yajra\DataTables\Html\Column;

class TagDataTable extends Base\DataTable {

    public function __construct() {
        parent::__construct(
            Resource::class,
            route('backend.tags'),
        );
    }

    protected function getColumns() {
        return [
            Column::computed('id')
                ->title( __('products-catalog::tag.id.0') )
                ->hidden(),

            Column::make('name')
                ->title( __('products-catalog::tag.name.0') ),

            Column::make('actions'),
        ];
    }

}
