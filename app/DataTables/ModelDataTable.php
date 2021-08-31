<?php

namespace HDSSolutions\Laravel\DataTables;

use HDSSolutions\Laravel\Models\Model as Resource;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Column;

class ModelDataTable extends Base\DataTable {

    protected array $with = [
        'brand'
    ];

    protected array $withCount = [
        'products',
    ];

    protected array $orderBy = [
        'brand.name'    => 'asc',
        'name'          => 'asc',
    ];

    public function __construct() {
        parent::__construct(
            Resource::class,
            route('backend.models'),
        );
    }

    protected function getColumns() {
        return [
            Column::computed('id')
                ->title( __('products-catalog::model.id.0') )
                ->hidden(),

            Column::make('brand.name')
                ->title( __('products-catalog::model.brand_id.0') ),

            Column::make('name')
                ->title( __('products-catalog::model.name.0') ),

            Column::computed('products')
                ->title( __('products-catalog::model.products.0') )
                ->renderRaw('view:model')
                ->data( view('products-catalog::models.datatable.products')->render() )
                ->class('w-150px'),

            Column::computed('actions'),
        ];
    }

    protected function joins(Builder $query):Builder {
        // add custom JOIN to brand
        return $query
            // JOIN to Brand
            ->join('brands', 'brands.id', 'models.brand_id');
    }

    protected function orderBrandName(Builder $query, string $order):Builder {
        // order by Brand.name
        return $query->orderBy('brands.name', $order);
    }

    protected function filterBrand(Builder $query, $brand_id):Builder {
        // filter only from brand
        return $query->where('brand_id', $brand_id);
    }

}
