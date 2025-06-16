@extends('layouts.app')
 
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header d-md-flex justify-content-between text-capitalize">
                Manage kontak
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    {{ $dataTable->table() }}
                </div>
            </div>
        </div>
    </div>
@endsection
 
@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush