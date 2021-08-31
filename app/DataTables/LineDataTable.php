<?php

namespace HDSSolutions\Laravel\DataTables;

use HDSSolutions\Laravel\Models\Line as Resource;
use Yajra\DataTables\Html\Column;

class LineDataTable extends Base\DataTable {

    protected array $withCount = [
        'gamas',
        'products',
    ];

    protected array $orderBy = [
        'name'  => 'asc',
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

            Column::computed('gamas')
                ->title( __('products-catalog::line.gamas.0') )
                ->renderRaw('view:line')
                ->data( view('products-catalog::lines.datatable.gamas')->render() )
                ->class('w-150px'),

            Column::computed('products')
                ->title( __('products-catalog::line.products.0') )
                ->renderRaw('view:line')
                ->data( view('products-catalog::lines.datatable.products')->render() )
                ->class('w-150px'),

            Column::computed('actions'),
        ];
    }

}
