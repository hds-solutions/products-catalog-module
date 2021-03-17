<?php

namespace HDSSolutions\Finpar\DataTables;

use HDSSolutions\Finpar\Models\Model as Resource;
use Yajra\DataTables\Html\Column;

class ModelDataTable extends Base\DataTable {

    protected array $with = [
        'brand'
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

            Column::make('actions'),
        ];
    }

}
