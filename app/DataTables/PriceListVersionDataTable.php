<?php

namespace HDSSolutions\Laravel\DataTables;

use HDSSolutions\Laravel\Models\PriceListVersion as Resource;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Column;

class PriceListVersionDataTable extends Base\DataTable {

    protected array $with = [
        'priceList',
    ];

    protected array $orderBy = [
        'price_list.name'   => 'ASC',
        'valid_from'        => 'DESC',
        'valid_until'       => 'DESC',
    ];

    public function __construct() {
        parent::__construct(
            Resource::class,
            route('backend.price_list_versions'),
        );
    }

    protected function getColumns() {
        return [
            Column::computed('id')
                ->title( __('products-catalog::price_list_version.id.0') )
                ->hidden(),

            Column::make('price_list.name')
                ->title( __('products-catalog::price_list_version.price_list_id.0') ),

            Column::make('name')
                ->title( __('products-catalog::price_list_version.name.0') ),

            Column::make('description')
                ->title( __('products-catalog::price_list_version.description.0') ),

            Column::make('valid_from')
                ->title( __('products-catalog::price_list_version.valid_from.0') )
                ->renderRaw('datetime:valid_from;F j, Y H:i'),

            Column::make('valid_until')
                ->title( __('products-catalog::price_list_version.valid_until.0') )
                ->renderRaw('datetime:valid_until;F j, Y H:i'),

            Column::computed('actions'),
        ];
    }

    protected function joins(Builder $query):Builder {
        // add custom JOINs
        return $query
            // join to PriceList
            ->join('price_lists', 'price_lists.id', 'price_list_versions.price_list_id');
    }

    protected function orderPriceListName(Builder $query, string $order):Builder {
        // order by PriceList.name
        return $query->orderBy('price_lists.name', $order);
    }

}
