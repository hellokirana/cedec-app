<?php

namespace App\DataTables;

use App\Models\WorkshopRegistration;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class WorkshopRegistrationDataTable extends DataTable
{
    protected $workshopId;

    public function __construct($workshopId = null)
    {
        $this->workshopId = $workshopId;
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('user.name', function ($model) {
                return $model->user ? $model->user->name : '-';
            })
            ->editColumn('user.email', function ($model) {
                return $model->user ? $model->user->email : '-';
            })
            ->editColumn('transfer_proof', function ($model) {
                if ($model->transfer_proof) {
                    return '<a href="' . $model->transfer_proof_url . '" target="_blank" class="btn btn-sm btn-outline-primary">
                        <i class="ri-file-image-line"></i> View
                    </a>';
                }
                return '<span class="text-muted">No proof</span>';
            })
            ->editColumn('payment_status', function ($model) {
                $badgeClass = match ($model->payment_status) {
                    'pending' => 'badge-warning',
                    'paid' => 'badge-success',
                    'unpaid' => 'badge-danger',
                    default => 'badge-secondary'
                };
                return '<span class="badge ' . $badgeClass . '">' . ucfirst($model->payment_status) . '</span>';
            })
            ->editColumn('status', function ($model) {
                $badgeClass = match ($model->status) {
                    'pending' => 'badge-warning',
                    'approved' => 'badge-success',
                    'rejected' => 'badge-danger',
                    default => 'badge-secondary'
                };
                return '<span class="badge ' . $badgeClass . '">' . ucfirst($model->status) . '</span>';
            })
            ->editColumn('created_at', function ($model) {
                return $model->created_at ? $model->created_at->format('d M Y H:i') : '-';
            })
            ->orderColumn('created_at', function ($query, $order) {
                $query->orderBy('workshop_registrations.created_at', $order);
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('workshop.registration.edit', [$this->workshopId, $row->id]);
                $deleteUrl = route('workshop.registration.destroy', [$this->workshopId, $row->id]);

                return '
                    <a href="' . $editUrl . '" class="btn btn-warning btn-sm mx-1" title="Edit"><i class="ri-file-edit-line"></i></a>
                    <a href="#" data-url_href="' . $deleteUrl . '" class="btn btn-danger btn-sm mx-1 delete-post" title="Delete" data-csrf="' . csrf_token() . '"><i class="ri-delete-bin-2-line"></i></a>
                ';
            })
            ->rawColumns(['transfer_proof', 'payment_status', 'status', 'action']);
    }

    public function query(WorkshopRegistration $model): QueryBuilder
    {
        return $model->newQuery()
            ->where('workshop_id', $this->workshopId)
            ->with(['workshop', 'user'])
            ->orderBy('workshop_registrations.created_at', 'desc');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('workshop-registration-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle();
    }

    public function getColumns(): array
    {
        return [
            Column::make('user.name')->title('Nama Peserta')->name('user.name'),
            Column::make('user.email')->title('Email')->name('user.email'),
            Column::make('time')->title('Waktu Daftar'),
            Column::make('transfer_proof')->title('Bukti Transfer')->orderable(false)->searchable(false),
            Column::make('payment_status')->title('Status Pembayaran'),
            Column::make('status')->title('Status'),
            Column::make('created_at')->title('Tanggal Daftar'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(120)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'WorkshopRegistration_' . date('YmdHis');
    }
}