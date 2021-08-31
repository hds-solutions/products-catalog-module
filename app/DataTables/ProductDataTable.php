<?php

namespace HDSSolutions\Laravel\DataTables;

use HDSSolutions\Laravel\Models\Product as Resource;
use Illuminate\Database\Eloquent\Builder;
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
        'variants.values.optionValue',
        // TODO: 'storages',
        // TODO: 'variants.storages',
    ];

    protected array $orderBy = [
        'name'      => 'asc',
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

            Column::computed('prices')
                ->title( __('products-catalog::product.prices.0') )
                ->renderRaw('view:product')
                ->data( view('products-catalog::products.datatable.prices')->render() )
                ->addClass('w-300px'),

            Column::computed('actions'),
        ];
    }

    protected function joins(Builder $query):Builder {
        // add custom JOINs
        return $query
            // join to Type
            ->join('types', 'types.id', 'products.type_id')
            // join to Brand
            ->leftJoin('brands', 'brands.id', 'products.brand_id')
                // join to Models
                ->leftJoin('models', 'models.id', 'products.model_id')
            // join to Line
            ->leftJoin('lines', 'lines.id', 'products.line_id');
    }

    protected function orderLineName(Builder $query, string $order):Builder {
        // order by Line.name
        return $query->orderBy('lines.name', $order);
    }

    protected function filterType(Builder $query, $type_id):Builder {
        // filter only from Type
        return $query->where('products.type_id', $type_id);
    }

    protected function filterBrand(Builder $query, $brand_id):Builder {
        // filter only from Brand
        return $query->where('products.brand_id', $brand_id);
    }

    protected function filterModel(Builder $query, $model_id):Builder {
        // filter only from Model
        return $query->where('products.model_id', $model_id);
    }

    protected function filterFamily(Builder $query, $family_id):Builder {
        // filter only from Family
        return $query->where('products.family_id', $family_id);
    }

    protected function filterSubFamily(Builder $query, $sub_family_id):Builder {
        // filter only from SubFamily
        return $query->where('products.sub_family_id', $sub_family_id);
    }

    protected function filterLine(Builder $query, $line_id):Builder {
        // filter only from Line
        return $query->where('products.line_id', $line_id);
    }

    protected function filterGama(Builder $query, $gama_id):Builder {
        // filter only from Gama
        return $query->where('products.gama_id', $gama_id);
    }

}
