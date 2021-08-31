<?php

namespace HDSSolutions\Laravel\DataTables;

use HDSSolutions\Laravel\Models\Variant as Resource;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Column;

class VariantDataTable extends Base\DataTable {

    protected array $with = [
        'product',
        'images',
        'values.option',
        'values.optionValue',
    ];

    protected array $orderBy = [
        'product.name'  => 'asc',
        'sku'           => 'asc',
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

            Column::computed('actions'),
        ];
    }

    protected function joins(Builder $query):Builder {
        // add custom JOIN to Product
        return $query
            // JOIN to Product
            ->join('products', 'products.id', 'variants.product_id');
    }

    protected function orderProductName(Builder $query, string $order):Builder {
        // order by Product.name
        return $query->orderBy('products.name', $order);
    }

    protected function filterProduct(Builder $query, $product_id):Builder {
        // filter only from Product
        return $query->where('product_id', $product_id);
    }

}
