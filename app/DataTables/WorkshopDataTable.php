<?php

namespace App\DataTables;

use App\Models\Workshop;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class WorkshopDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('image', function ($model) {
                return '<img src="' . $model->image_url . '" class="img-fluid" style="max-height:80px;">';
            })
            ->editColumn('status', function ($model) {
                return $model->status ? 'Active' : 'Inactive';
            })
            ->addColumn('registrations_count', function ($model) {
                return $model->registrations_count ?? 0;
            })
            ->addColumn('action', function ($row) {
                $editUrl = url('data/workshop/' . $row->id . '/edit');
                $deleteUrl = route('workshop.destroy', $row->id);
                $registrationsUrl = route('workshop.registrations', $row->id);

                return '
                    <a href="' . $registrationsUrl . '" class="btn btn-info btn-sm mx-1" title="View Registrations"><i class="ri-group-line"></i></a>
                    <a href="' . $editUrl . '" class="btn btn-warning btn-sm mx-1" title="Edit"><i class="ri-file-edit-line"></i></a>
                    <a href="#" data-url_href="' . $deleteUrl . '" class="btn btn-danger btn-sm mx-1 delete-post" title="Delete" data-csrf="' . csrf_token() . '"><i class="ri-delete-bin-2-line"></i></a>
                ';
            })
            ->rawColumns(['image', 'action']);
    }

    public function query(Workshop $model): QueryBuilder
    {
        return $model->newQuery()
            ->withCount('registrations')
            ->latest();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('workshop-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle();
    }

    public function getColumns(): array
    {
        return [
            Column::make('image')->width(50)->orderable(false)->searchable(false),
            Column::make('title'),
            Column::make('place'),
            Column::make('fee')->title('Fee'),
            Column::make('quota'),
            Column::make('registrations_count')->title('Registrations')->width(100),
            Column::make('workshop_start_date')->title('Start Date'),
            Column::make('workshop_end_date')->title('End Date'),
            Column::make('status'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(150)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Workshop_' . date('YmdHis');
    }
}