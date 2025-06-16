<?php

namespace App\DataTables;

use App\Models\Bank;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BankDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('status', function ($model) {
                return @$model->status_text;
            })
            ->addColumn('action', function ($row) {
                $button = '<a href="' . url('data/bank/' . $row->id . '/edit') . '" class="btn btn-warning btn-sm mx-1" data-bs-toggle="tooltip" title="Edit"><i class="ri-file-edit-line"></i></a>';
                $button .= '<a href="#" data-url_href="' . route('bank.destroy', $row->id) . '" class="btn btn-danger btn-sm mx-1 delete-post" data-bs-toggle="tooltip" title="Delete"  data-csrf="' . csrf_token() . '"><i class="ri-delete-bin-2-line"></i></a>';

                return $button;
            })
            ->rawColumns([ 'action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Bank $model): QueryBuilder
    {
        return $model->newQuery()->latest();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('Bank-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                // Button::make('excel'),
                // Button::make('csv'),
                // Button::make('pdf'),
                // Button::make('print'),
                // Button::make('reset'),
                // Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [

            Column::make('no_urut')->width(50)->orderable(false)->searchable(false),
            Column::make('nama'),
            Column::make('bank'),
            Column::make('no_rekening'),
            Column::make('status')->width(50)->orderable(false)->searchable(false),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(120)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Bank_' . date('YmdHis');
    }
}
