@extends('layouts.app')
 
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header d-md-flex justify-content-between">
                <div>
                    <h5 class="mb-0">Payment Confirmation</h5>
                    <small class="text-muted">Manage workshop payment confirmations</small>
                </div>
                <div>
                    <a href="{{ route('workshop.index') }}" class="btn btn-secondary">
                        <i class="ri-arrow-left-line"></i> Back to Workshop
                    </a>
                </div>
            </div>
            <div class="card-body">
                <!-- Payment Statistics -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card border-left-warning">
                            <div class="card-body">
                                <h6 class="card-title">Under Review</h6>
                                <h4 class="mb-0">{{ $stats['under_review'] }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-left-success">
                            <div class="card-body">
                                <h6 class="card-title">Completed</h6>
                                <h4 class="mb-0">{{ $stats['completed'] }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-left-danger">
                            <div class="card-body">
                                <h6 class="card-title">Rejected</h6>
                                <h4 class="mb-0">{{ $stats['rejected'] }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-left-info">
                            <div class="card-body">
                                <h6 class="card-title">Total Payments</h6>
                                <h4 class="mb-0">{{ $stats['total'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>        
    <div class="card">
        <div class="card-header">Pending Registrations</div>
        <div class="card-body">
            {!! $dataTable->table(['class' => 'table table-bordered table-striped'], true) !!}
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {!! $dataTable->scripts(attributes: ['type' => 'module']) !!}

    <script>
        $(document).ready(function () {
            // Handle Confirm
            $(document).on('click', '.confirm-payment', function (e) {
                e.preventDefault();
                let url = $(this).data('url');

                Swal.fire({
                    title: 'Confirm Payment?',
                    text: 'Are you sure you want to confirm this payment?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Confirm',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            });

            // Handle Reject
            $(document).on('click', '.reject-payment', function (e) {
                e.preventDefault();
                let url = $(this).data('url');

                Swal.fire({
                    title: 'Reject Payment?',
                    text: 'Are you sure you want to reject this payment?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Reject',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            });
        });
    </script>
@endpush

