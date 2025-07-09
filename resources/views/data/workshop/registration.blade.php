@extends('layouts.app')
 
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header d-md-flex justify-content-between">
                <div>
                    <h5 class="mb-0">Workshop Registrations</h5>
                    <small class="text-muted">{{ $workshop->title }}</small>
                </div>
                <div>
                    <a href="{{ route('workshop.index') }}" class="btn btn-secondary">
                        <i class="ri-arrow-left-line"></i> Back to Workshop
                    </a>
                </div>
            </div>
            <div class="card-body">
                <!-- Workshop Info -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card border-left-primary">
                            <div class="card-body">
                                <h6 class="card-title">Workshop Information</h6>
                                <p class="mb-1"><strong>Title:</strong> {{ $workshop->title }}</p>
                                <p class="mb-1"><strong>Place:</strong> {{ $workshop->place ?? '-' }}</p>
                                <p class="mb-1"><strong>Date:</strong> {{ date('d M Y', strtotime($workshop->workshop_start_date)) }} - {{ date('d M Y', strtotime($workshop->workshop_end_date)) }}</p>
                                <p class="mb-1"><strong>Time:</strong> {{ $workshop->time ?? '-' }}</p>
                                <p class="mb-1"><strong>Fee:</strong> {{ $workshop->fee ? 'Rp ' . number_format($workshop->fee, 0, ',', '.') : 'Free' }}</p>
                                <p class="mb-0"><strong>Quota:</strong> {{ $workshop->quota ?? 'Unlimited' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-left-info">
                            <div class="card-body">
                                <h6 class="card-title">Registration Statistics</h6>
                                <div class="row">
                                    <div class="col-6">
                                        <p class="mb-1"><strong>Total:</strong> {{ $workshop->registrations_count ?? 0 }}</p>
                                        <p class="mb-1"><strong>Approved:</strong> {{ $workshop->registrations()->where('status', 'approved')->count() }}</p>
                                        <p class="mb-0"><strong>Pending:</strong> {{ $workshop->registrations()->where('status', 'pending')->count() }}</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="mb-1"><strong>Rejected:</strong> {{ $workshop->registrations()->where('status', 'rejected')->count() }}</p>
                                        <p class="mb-1"><strong>Paid:</strong> {{ $workshop->registrations()->where('payment_status', 'paid')->count() }}</p>
                                        <p class="mb-0"><strong>Unpaid:</strong> {{ $workshop->registrations()->where('payment_status', 'unpaid')->count() }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Registrations DataTable -->
                <div class="table-responsive">
                    {{ $dataTable->table(['class' => 'table table-striped table-bordered']) }}
                </div>
            </div>
        </div>
    </div>
@endsection
 
@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush