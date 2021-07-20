<?php

namespace HDSSolutions\Laravel\DataTables;

use HDSSolutions\Laravel\Models\Variant as Resource;
use Yajra\DataTables\Html\Column;

class VariantDataTable extends Base\DataTable {

    protected array $with = [
        'product',
        'images',
        'values.option',
        'values.optionValue',
    ];

    public function __construct() {
        parent::__construct(
            Resource::class,
            route('backend.variants'),
        );
    }

    protected function getColumns() {
        return [
            Column::computed('id')
                ->title( __('products-catalog::variant.id.0') )
                ->hidden(),

            Column::computed('image')
                ->title( __('products-catalog::variant.image_id.0') )
                ->renderRaw('image:images[0].url'),

            Column::make('product.name')
                ->title( __('products-catalog::variant.product_id.0') ),

            Column::make('sku')
                ->title( __('products-catalog::variant.sku.0') ),

            Column::computed('variant')
                ->title( __('products-catalog::variant.variant.0') )
                ->renderRaw('view:variant')
                ->data( view('products-catalog::variants.datatable.variant')->render() ),

            Column::make('actions'),
        ];
    }

}
