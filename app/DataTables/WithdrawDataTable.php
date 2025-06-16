<?php

namespace App\DataTables;

use App\Models\Withdraw;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class WithdrawDataTable extends DataTable
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
            ->editColumn('nominal', function ($model) {
                return formating_number($model->nominal, 0);
            })
            ->editColumn('worker_id', function ($model) {
                return @$model->worker->name;
            })
            ->addColumn('action', function ($row) {
                $button = '';
                if (Auth()->user()->getRoleNames()[0] == 'superadmin') {

                    if ($row->status == '1') {
                        $button .= '<a href="#" data-url="' . url('data/withdraw/' . $row->id . '/diproses') . '" class="btn btn-info btn-sm mb-1 w-100 update_data" data-bs-toggle="tooltip" title="bayar_diterima">Diproses</a>';
                        $button .= '<a href="#" data-url="' . url('data/withdraw/' . $row->id . '/ditolak') . '" class="btn btn-warning btn-sm mb-1 w-100 update_data" data-bs-toggle="tooltip" title="ditolak">Ditolak</a>';
                    }
                    if ($row->status == '2') {
                        $button .= '<a href="#" data-url="' . url('data/withdraw/' . $row->id . '/selesai') . '" class="btn btn-info btn-sm mb-1 w-100 update_data" data-bs-toggle="tooltip" title="bayar_diterima">selesai</a>';
                        
                    }
                    $button .= '<a href="#" data-url_href="' . route('withdraw.destroy', $row->id) . '" class="w-100 my-1 btn btn-danger btn-sm  delete-post" data-bs-toggle="tooltip" title="Delete"  data-csrf="' . csrf_token() . '">Hapus</a>';
                }

                return $button;
            })
            ->rawColumns(['action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Withdraw $model): QueryBuilder
    {
        $user = auth()->user();

        // Start building the query
        $query = $model->newQuery()->latest();

        if ($user->getRoleNames()[0] === 'worker') {
            $query->where('worker_id', $user->id);
        }
        // For superadmin, no additional filters are applied

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('Withdraw-table')
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
        // Get the user's role (assuming you have access to the user's role in this context)
        $userRole = auth()->user()->getRoleNames()[0];

        // Define all columns
        $columns = [
            Column::make('worker_id')->title('worker'),
            Column::make('nominal'),

            Column::make('bank'),
            Column::make('nama'),
            Column::make('no_rekening'),
            Column::make('status'),
            Column::make('updated_at'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(150)
                ->addClass('text-center'),
        ];

        // Filter columns based on the user's role
        if ($userRole === 'worker') {
            $columns = array_filter($columns, function ($column) {
                return !in_array($column->name, ['worker_id','action']);
            });
        }
        // For superadmin, no filtering is needed; all columns are shown.

        return array_values($columns); // Ensure keys are reset
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Withdraw_' . date('YmdHis');
    }
}
