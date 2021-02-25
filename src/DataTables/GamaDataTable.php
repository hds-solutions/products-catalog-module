<?php

namespace HDSSolutions\Finpar\DataTables;

use HDSSolutions\Finpar\Models\Gama as Resource;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class GamaDataTable extends DataTable {
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query) {
        // return datatable class for current eloquent model
        return datatables()->eloquent($query);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Resource $resource
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Resource $resource) {
        // return new query for current eloquent model
        return $resource->newQuery()
            ->with([ 'line' ]);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html() {
        // return builder with custom columns
        return $this->builder()
                    // ->setTableId('user-table')
                    ->columns($this->getColumns())
                    // ->postAjax( route('backend.users') );
                    // ->dom('Bfrtip')
                    ->orderBy(1);
                    // ->buttons(
                    //     Button::make('create'),
                    //     Button::make('export'),
                    //     Button::make('print'),
                    //     Button::make('reset'),
                    //     Button::make('reload'),
                    // );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns() {
        return [
            Column::make('id')->title( __('products-catalog/gama.id.0') )->hidden(),
            Column::make('line')->data('line.name')->title( __('products-catalog/gama.line_id.0') ),
            Column::make('name')->title( __('products-catalog/gama.name.0') ),
            Column::make('actions'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename() {
        return basename(Resource::class).'_' . date('YmdHis');
    }

}
