<?php

namespace HDSSolutions\Finpar\DataTables;

use HDSSolutions\Finpar\Models\Product as Resource;
use Yajra\DataTables\Html\Column;

class ProductDataTable extends Base\DataTable {

    protected array $with = [
        // 'brand', 'model',
        // 'family', 'sub_family',
        'line', //'gama',
        // TODO: 'offers',
        // 'categories',
        // 'tags',
        'images',
        'prices',
        'variants.prices',
        'variants.values.option',
        'variants.values.option_value',
        // TODO: 'storages',
        // TODO: 'variants.storages',
    ];

    public function __construct() {
        parent::__construct(
            Resource::class,
            route('backend.products'),
        );
    }

    protected function getColumns() {
        return [
            Column::computed('id')
                ->title( __('products-catalog::product.id.0') )
                ->hidden(),

            Column::computed('image')
                ->title( __('products-catalog::product.image_id.0') )
                ->renderRaw('image:images[0].url'),

            Column::make('name')
                ->title( __('products-catalog::product.name.0') )
                ->renderRaw('view:product')
                ->data( view('products-catalog::products.datatable.name')->render() ),

            Column::make('line.name')
                ->title( __('products-catalog::product.line_id.0') ),

            Column::make('prices')
                ->title( __('products-catalog::product.prices.0') )
                ->renderRaw('view:product')
                ->data( view('products-catalog::products.datatable.prices')->render() )
                ->addClass('w-300px')
                ->sortable(false),

            Column::make('actions'),
        ];
    }

}
