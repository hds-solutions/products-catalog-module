<?php

namespace HDSSolutions\Laravel\DataTables;

use HDSSolutions\Laravel\Models\Gama as Resource;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Column;

class GamaDataTable extends Base\DataTable {

    protected array $with = [
        'line',
    ];

    protected array $withCount = [
        'products',
    ];

    public function __construct() {
        parent::__construct(
            Resource::class,
            route('backend.gamas'),
        );
    }

    protected function getColumns() {
        return [
            Column::computed('id')
                ->title( __('products-catalog::gama.id.0') )
                ->hidden(),

            Column::make('line.name')
                ->title( __('products-catalog::gama.line_id.0') ),

            Column::make('name')
                ->title( __('products-catalog::gama.name.0') ),

            Column::make('products')
                ->title( __('products-catalog::gama.products.0') )
                ->renderRaw('view:gama')
                ->data( view('products-catalog::gamas.datatable.products')->render() ),

            Column::computed('actions'),
        ];
    }

    protected function joins(Builder $query):Builder {
        // add custom JOIN to line
        return $query
            // JOIN to Lines
            ->join('lines', 'lines.id', 'gamas.line_id');
    }

    protected function orderLineName(Builder $query, string $order):Builder {
        // order by Line.name
        return $query->orderBy('lines.name', $order);
    }

    protected function filterLine(Builder $query, $line_id):Builder {
        // filter only from line
        return $query->where('line_id', $line_id);
    }

}
