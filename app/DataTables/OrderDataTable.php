<?php

namespace App\DataTables;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class OrderDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('bukti_transfer', function ($model) {
                return '<img src="' . $model->bukti_transfer_url . '" class="img-fluid">';
            })
            ->editColumn('status', function ($model) {
                return @$model->status_text;
            })
            ->editColumn('updated_at', function ($model) {
                return @$model->updated_at->format('m-d H:i');
            })
            ->editColumn('harga_member', function ($model) {
                return formating_number($model->harga_member, 0);
            })
            ->editColumn('harga_worker', function ($model) {
                return formating_number($model->harga_worker, 0);
            })
            ->editColumn('nominal', function ($model) {
                return formating_number($model->nominal, 0);
            })
            ->editColumn('status_pembayaran', function ($model) {
                return @$model->status_pembayaran_text;
            })
            ->editColumn('status_order', function ($model) {
                return @$model->status_order_text;
            })

            ->editColumn('layanan_id', function ($model) {
                return @$model->layanan->title;
            })
            ->editColumn('customer_id', function ($model) {
                return @$model->customer->name;
            })
            ->editColumn('worker_id', function ($model) {
                return @$model->worker->name;
            })
            ->addColumn('action', function ($row) {
                $button = '<a href="' . url('data/order/' . $row->id) . '" class="w-100 my-1 btn btn-primary btn-sm " data-bs-toggle="tooltip" title="info">Detail</a>';
                if(Auth()->user()->getRoleNames()[0] == 'superadmin'){
                    
                    if($row->status_order == '1'){
                        if($row->status_pembayaran == '2'){
                            $button .= '<a href="#" data-url="' . url('data/order/' . $row->id . '/bayar_diterima') . '" class="btn btn-info btn-sm mb-1 w-100 update_data" data-bs-toggle="tooltip" title="bayar_diterima">Bayar diterima</a>';
                            $button .= '<a href="#" data-url="' . url('data/order/' . $row->id . '/bayar_ditolak') . '" class="btn btn-warning btn-sm mb-1 w-100 update_data" data-bs-toggle="tooltip" title="bayar_ditolak">Bayar ditolak</a>';
                        }
                    }
                    $button .= '<a href="#" data-url_href="' . route('order.destroy', $row->id) . '" class="w-100 my-1 btn btn-danger btn-sm  delete-post" data-bs-toggle="tooltip" title="Delete"  data-csrf="' . csrf_token() . '">Hapus</a>';
                }
                if(Auth()->user()->getRoleNames()[0] == 'member' && $row->status_order == '1'){
                    $button .= '<a href="' . url('data/order/' . $row->id.'/konfirmasi') . '" class="w-100 my-1 btn btn-warning btn-sm " data-bs-toggle="tooltip" title="info">konfirmasi</a>';
                }
                if(Auth()->user()->getRoleNames()[0] == 'worker' && $row->status_order == '1'){
                    $button .= '<a href="' . url('data/order/' . $row->id.'/terima_order') . '" class="w-100 my-1 btn btn-primary btn-sm " data-bs-toggle="tooltip" title="info">Terima Order</a>';
                }
                

                return $button;
            })
            ->rawColumns(['bukti_transfer', 'action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Order $model): QueryBuilder
    {
        // Get the current authenticated user's role and ID
        $user = auth()->user();

        // Start building the query
        $query = $model->newQuery()->latest();

        // Apply filters based on the user's role
        if ($user->getRoleNames()[0] === 'member') {
            $query->where('customer_id', $user->id);
        } elseif ($user->getRoleNames()[0] === 'worker') {
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
            ->setTableId('Order-table')
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
            Column::make('layanan_id')->title('layanan'),
            Column::make('customer_id')->title('customer'),
            Column::make('worker_id')->title('worker'),
            Column::make('harga_member'),
            Column::make('harga_worker'),
            Column::make('nominal'),
            Column::make('waktu'),
            Column::make('alamat'),
            Column::make('bukti_transfer'),
            Column::make('status_pembayaran'),
            Column::make('status_order'),
            Column::make('updated_at'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(150)
                ->addClass('text-center'),
        ];

        // Filter columns based on the user's role
        if ($userRole === 'member') {
            $columns = array_filter($columns, function ($column) {
                return !in_array($column->name, ['customer_id', 'harga_member', 'harga_worker', 'alamat']);
            });
        } elseif ($userRole === 'worker') {
            $columns = array_filter($columns, function ($column) {
                return !in_array($column->name, ['worker_id', 'harga_member', 'nominal', 'bukti_transfer', 'status_pembayaran']);
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
        return 'Order_' . date('YmdHis');
    }
}
