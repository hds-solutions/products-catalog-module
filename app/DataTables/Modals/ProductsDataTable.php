<?php

namespace HDSSolutions\Laravel\DataTables\Modals;

use HDSSolutions\Laravel\Models\Variant as Resource;
use HDSSolutions\Laravel\DataTables\Base\DataTable;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Column;

class ProductsDataTable extends DataTable {

    protected array $with = [
        'images',
        // 'values.option',
        // 'values.optionValue',
    ];

    protected array $orderBy = [
        'name'  => 'asc',
        'sku'   => 'asc',
    ];

    public function __construct() {
        parent::__construct(
            Resource::class,
            route('backend.products.search'),
        );
        // add prices to eager loading (only prices from PriceList set on POS setting)
        $this->with += [
            'prices' => fn($priceListVersion) => $priceListVersion
                // order prices and get only valid ones
                ->ordered()->valid()
                // load only sale PriceList
                ->where('price_list_id', pos_settings()->priceList()->id)
                ->with([ 'priceList.currency' ]),
            'product.prices' => fn($priceListVersion) => $priceListVersion
                // order prices and get only valid ones
                ->ordered()->valid()
                // load only sale PriceList
                ->where('price_list_id', pos_settings()->priceList()->id)
                ->with([ 'priceList.currency' ]),
        ];
    }

    protected function newQuery():Builder {
        // return new query for current eloquent model
        return (new Resource)->newQuery()
            // select only resource table data (custom joins breaks data)
            ->select(
                'variants.*',
                'products.name',
                'products.code',
                'products.tax',
            );
    }

    protected function joins(Builder $query):Builder {
        // load products with Variants
        return $query->leftJoin('products', 'variants.product_id', 'products.id')

            // join to Type
            ->join('types', 'types.id', 'products.type_id')
            // join to Brand
            ->leftJoin('brands', 'brands.id', 'products.brand_id')
                // join to Models
                ->leftJoin('models', 'models.id', 'products.model_id')
            // join to Line
            ->leftJoin('lines', 'lines.id', 'products.line_id');
    }

    protected function results($results) {
        return $results->transform(fn($variant) => $variant
            // modify prices relation, link to parent resources manually to avoid more queries
            ->setRelation('prices', $variant->prices->take(1)->transform(fn($priceListVersion) => $priceListVersion
                ->setRelation('price', $priceListVersion->price
                    // reset PriceListVersion relation without relations
                    ->setRelation('priceListVersion', $priceListVersion->withoutRelations()
                        // set PriceList relation
                        ->setRelation('priceList', $priceListVersion->priceList)
                    )
                )
            ))
        );
    }

    protected function getTableId():string {
        return class_basename($this->resource).'-modal';
    }

    protected function parameters():array {
        return [
            'info'      => false,
            'paging'    => false,
            'searching' => false,
        ];
    }

    protected function getColumns() {
        return [
            Column::computed('id')
                ->title( __('products-catalog::product.id.0') )
                ->hidden(),

            Column::computed('image')
                ->title( __('products-catalog::product.image_id.0') )
                ->renderRaw('image:images[0].url;mh-50px'),

            Column::make('sku')
                ->title( __('products-catalog::product.sku.0') ),

            Column::make('name')
                ->title( __('products-catalog::product.name.0') ),
            //     // ->renderRaw('view:product')
            //     // ->data( view('products-catalog::products.datatable.name')->render() ),

            // Column::make('line.name')
            //     ->title( __('products-catalog::product.line_id.0') ),

            // Column::computed('variant')
            //     ->title( '' )
            //     ->renderRaw('view:variant')
            //     ->data( view('products-catalog::components.products.modal.variant')->render() ),

            Column::computed('prices')
                ->title( __('products-catalog::product.prices.0') )
                ->renderRaw('view:variant')
                ->data( view('products-catalog::components.products.modal.prices')->render() )
                ->addClass('w-150px text-right'),
        ];
    }

    protected function orderLineName(Builder $query, string $order):Builder {
        // order by Line.name
        return $query->orderBy('lines.name', $order);
    }

    protected function filterCode(Builder $query, $code):Builder {
        // filter only from Type
        return $query->where(fn($group) => $group
            ->where('products.code', 'LIKE', "$code%")
            ->orWhere('variants.sku', 'LIKE', "$code%")
            ->orWhere('products.name', 'LIKE', "%$code%")
        );
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
