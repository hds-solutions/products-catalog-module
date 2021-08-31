<?php

namespace HDSSolutions\Laravel\DataTables;

use HDSSolutions\Laravel\Models\Brand as Resource;
use Yajra\DataTables\Html\Column;

class BrandDataTable extends Base\DataTable {

    protected array $withCount = [
        'models',
        'products',
    ];

    protected array $orderBy = [
        'name'  => 'asc',
    ];

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

            Column::computed('models')
                ->title( __('products-catalog::brand.models.0') )
                ->renderRaw('view:brand')
                ->data( view('products-catalog::brands.datatable.models')->render() )
                ->class('w-150px'),

            Column::computed('products')
                ->title( __('products-catalog::brand.products.0') )
                ->renderRaw('view:brand')
                ->data( view('products-catalog::brands.datatable.products')->render() )
                ->class('w-150px'),

            Column::computed('actions'),
        ];
    }

}
