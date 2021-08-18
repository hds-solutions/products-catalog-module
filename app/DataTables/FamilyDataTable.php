<?php

namespace HDSSolutions\Laravel\DataTables;

use HDSSolutions\Laravel\Models\Family as Resource;
use Yajra\DataTables\Html\Column;

class FamilyDataTable extends Base\DataTable {

    protected array $withCount = [
        'subFamilies',
        'products',
    ];

    public function __construct() {
        parent::__construct(
            Resource::class,
            route('backend.families'),
        );
    }

    protected function getColumns() {
        return [
            Column::computed('id')
                ->title( __('products-catalog::family.id.0') )
                ->hidden(),

            Column::make('name')
                ->title( __('products-catalog::family.name.0') ),

            Column::make('sub_families')
                ->title( __('products-catalog::family.sub_families.0') )
                ->renderRaw('view:family')
                ->data( view('products-catalog::families.datatable.sub_families')->render() ),

            Column::make('products')
                ->title( __('products-catalog::family.products.0') )
                ->renderRaw('view:family')
                ->data( view('products-catalog::families.datatable.products')->render() ),

            Column::computed('actions'),
        ];
    }

}
