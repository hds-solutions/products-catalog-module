<?php

namespace HDSSolutions\Laravel\DataTables;

use HDSSolutions\Laravel\Models\Line as Resource;
use Yajra\DataTables\Html\Column;

class LineDataTable extends Base\DataTable {

    protected array $withCount = [
        'gamas',
    ];

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

            Column::make('gamas')
                ->title( __('products-catalog::line.gamas.0') )
                ->renderRaw('view:line')
                ->data( view('products-catalog::lines.datatable.gamas')->render() ),

            Column::computed('actions'),
        ];
    }

}
