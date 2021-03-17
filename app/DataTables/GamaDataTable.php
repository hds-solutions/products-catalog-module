<?php

namespace HDSSolutions\Finpar\DataTables;

use HDSSolutions\Finpar\Models\Gama as Resource;
use Yajra\DataTables\Html\Column;

class GamaDataTable extends Base\DataTable {

    protected array $with = [
        'line'
    ];

    public function __construct() {
        parent::__construct(
            Resource::class,
            route('backend.gamas'),
        );
    }

    protected function getColumns() {
        return [
            Column::computed('id')
                ->title( __('products-catalog::gama.id.0') )
                ->hidden(),

            Column::make('line.name')
                ->title( __('products-catalog::gama.line_id.0') ),

            Column::make('name')
                ->title( __('products-catalog::gama.name.0') ),

            Column::make('actions'),
        ];
    }

}
