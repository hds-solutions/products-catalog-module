<?php

namespace HDSSolutions\Finpar\DataTables;

use HDSSolutions\Finpar\Models\SubFamily as Resource;
use Yajra\DataTables\Html\Column;

class SubFamilyDataTable extends Base\DataTable {

    protected array $with = [
        'family',
    ];

    public function __construct() {
        parent::__construct(
            Resource::class,
            route('backend.sub_families'),
        );
    }

    protected function getColumns() {
        return [
            Column::computed('id')
                ->title( __('products-catalog::sub_family.id.0') )
                ->hidden(),

            Column::make('family.name')
                ->title( __('products-catalog::sub_family.family_id.0') ),

            Column::make('name')
                ->title( __('products-catalog::sub_family.name.0') ),

            Column::make('actions'),
        ];
    }

}
