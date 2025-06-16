@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Dashboard Admin</h1>

    <div class="row">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h4>Total Pesanan</h4>
                    <h2>{{ $totalPesanan }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h4>Klaim Garansi Pending</h4>
                    <h2>{{ $totalKlaim }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h4>Total Voucher</h4>
                    <h2>{{ $totalVoucher }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h4>Total Layanan</h4>
                    <h2>{{ $totalLayanan }}</h2>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
