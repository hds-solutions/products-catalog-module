<?php

namespace HDSSolutions\Finpar\DataTables;

use HDSSolutions\Finpar\Models\Variant as Resource;
use Yajra\DataTables\Html\Column;

class VariantDataTable extends Base\DataTable {

    protected array $with = [
        'images',
        'values.option',
        'values.option_value',
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
                ->renderRaw('variant'),

            Column::make('actions'),
        ];
    }

}
