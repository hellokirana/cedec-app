<?php

namespace App\DataTables;

use App\Models\Program;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProgramDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('created_at', function ($model) {
                return $model->created_at->format('d M Y'); // contoh: 11 Jul 2025
            })

            ->addColumn('action', function ($row) {
                $editUrl = url('data/program/' . $row->id . '/edit');
                $deleteUrl = route('program.destroy', $row->id);
                $csrf = csrf_token();

                return '<a href="' . $editUrl . '" class="btn btn-warning btn-sm mx-1" title="Edit"><i class="ri-file-edit-line"></i></a>' .
                    '<a href="#" data-url_href="' . $deleteUrl . '" class="btn btn-danger btn-sm mx-1 delete-post" title="Delete" data-csrf="' . $csrf . '"><i class="ri-delete-bin-2-line"></i></a>';
            })
            ->editColumn('status', function ($model) {
                return $model->status ? 'Active' : 'Inactive';
            })
            ->rawColumns(['action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Program $model): QueryBuilder
    {
        return $model->newQuery()->latest();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('program-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle();
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->title('#')->width(50),
            Column::make('title')->title('Program Title'),
            Column::make('status')->title('Status')->width(100),
            Column::make('created_at')->title('Created At')->width(120),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(100)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Program_' . date('YmdHis');
    }
}
