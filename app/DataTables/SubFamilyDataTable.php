<?php

namespace HDSSolutions\Laravel\DataTables;

use HDSSolutions\Laravel\Models\SubFamily as Resource;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Column;

class SubFamilyDataTable extends Base\DataTable {

    protected array $with = [
        'family',
    ];

    protected array $withCount = [
        'products',
    ];

    protected array $orderBy = [
        'family.name'   => 'asc',
        'name'          => 'asc',
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

            Column::computed('products')
                ->title( __('products-catalog::sub_family.products.0') )
                ->renderRaw('view:sub_family')
                ->data( view('products-catalog::sub_families.datatable.products')->render() )
                ->class('w-150px'),

            Column::computed('actions'),
        ];
    }

    protected function joins(Builder $query):Builder {
        // add custom JOIN to Family
        return $query
            // JOIN to Family
            ->join('families', 'families.id', 'sub_families.family_id');
    }

    protected function orderFamilyName(Builder $query, string $order):Builder {
        // order by Family.name
        return $query->orderBy('families.name', $order);
    }

    protected function filterFamily(Builder $query, $family_id):Builder {
        // filter only from family
        return $query->where('family_id', $family_id);
    }

}
