<?php
namespace App\DataTables;

use App\Models\WorkshopRegistration;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PaymentConfirmationDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->editColumn('workshop.title', fn($m) => $m->workshop->title ?? '-')
            ->editColumn('user.name', fn($m) => $m->user->name ?? '-')
            ->editColumn('user.email', fn($m) => $m->user->email ?? '-')
            ->editColumn('workshop.fee', fn($m) => $m->workshop?->fee > 0 ? 'Rp ' . number_format($m->workshop->fee, 0, ',', '.') : 'Free')
            ->editColumn('transfer_proof', function ($m) {
                return $m->transfer_proof
                    ? '<a href="' . asset('storage/' . $m->transfer_proof) . '" target="_blank" class="btn btn-sm btn-outline-primary">View</a>'
                    : '<span class="text-muted">No Proof</span>';
            })
            ->editColumn('payment_status', function ($m) {
                $statuses = payment_status();
                $text = $statuses[$m->payment_status] ?? 'Unknown';
                $color = match ($m->payment_status) {
                    1 => 'bg-warning',
                    2 => 'bg-success',
                    3 => 'bg-danger',
                    default => 'bg-secondary'
                };
                return '<span class="badge ' . $color . '">' . $text . '</span>';
            })
            ->editColumn('created_at', fn($m) => $m->created_at?->format('d M Y H:i'))
            ->addColumn('action', function ($m) {
                if ($m->payment_status !== 1)
                    return '-';
                $confirm = url('data/workshop-registration/' . $m->id . '/confirm');
                $reject = url('data/workshop-registration/' . $m->id . '/reject');
                return "<a href='#' data-url='$confirm' class='btn btn-success btn-sm confirm-payment'>Confirm</a>
                        <a href='#' data-url='$reject' class='btn btn-danger btn-sm reject-payment'>Reject</a>";
            })
            ->rawColumns(['transfer_proof', 'payment_status', 'action']);
    }

    public function query(WorkshopRegistration $model)
    {
        return $model->newQuery()
            ->with(['user', 'workshop'])
            ->where('payment_status', 1)
            ->whereNotNull('transfer_proof');
    }

    public function html(): \Yajra\DataTables\Html\Builder
    {
        return $this->builder()
            ->setTableId('payment-confirmation-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(6);
    }

    public function getColumns(): array
    {
        return [
            Column::make('workshop.title')->title('Workshop'),
            Column::make('user.name')->title('Participant'),
            Column::make('user.email')->title('Email'),
            Column::make('workshop.fee')->title('Fee'),
            Column::make('transfer_proof')->title('Transfer Proof')->orderable(false)->searchable(false),
            Column::make('payment_status')->title('Status'),
            Column::make('created_at')->title('Submitted At'),
            Column::computed('action')->exportable(false)->printable(false)->addClass('text-center')
        ];
    }

    protected function filename(): string
    {
        return 'PaymentConfirmation_' . now()->format('YmdHis');
    }
}