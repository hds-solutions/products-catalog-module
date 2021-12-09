<?php

namespace HDSSolutions\Laravel\DataTables;

use HDSSolutions\Laravel\Models\PriceList as Resource;
use Yajra\DataTables\Html\Column;

class PriceListDataTable extends Base\DataTable {

    protected array $withCount = [
        'priceListVersions',
    ];

    protected array $orderBy = [
        'name'  => 'asc',
    ];

    public function __construct() {
        parent::__construct(
            Resource::class,
            route('backend.price_lists'),
        );
    }

    protected function getColumns() {
        return [
            Column::computed('id')
                ->title( __('products-catalog::price_list.id.0') )
                ->hidden(),

            Column::make('name')
                ->title( __('products-catalog::price_list.name.0') ),

            Column::make('description')
                ->title( __('products-catalog::price_list.description.0') ),

            Column::make('is_default')
                ->title( __('products-catalog::price_list.is_default.0') )
                ->renderRaw('boolean'),

            Column::computed('priceListVersions')
                ->title( __('products-catalog::price_list.price_list_versions.0') )
                ->renderRaw('view:price_list')
                ->data( view('products-catalog::price_lists.datatable.price-list-versions')->render() )
                ->class('w-150px'),

            Column::computed('actions'),
        ];
    }

}
