<?php

namespace HDSSolutions\Laravel\DataTables;

use HDSSolutions\Laravel\Models\Category as Resource;
use Yajra\DataTables\Html\Column;

class CategoryDataTable extends Base\DataTable {

    protected array $orderBy = [
        'name'  => 'asc',
    ];

    public function __construct() {
        parent::__construct(
            Resource::class,
            route('backend.categories'),
        );
    }

    protected function getColumns() {
        return [
            Column::computed('id')
                ->title( __('products-catalog::category.id.0') )
                ->hidden(),

            Column::make('name')
                ->title( __('products-catalog::category.name.0') ),

            Column::computed('actions'),
        ];
    }

}
