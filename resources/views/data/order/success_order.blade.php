@extends('layouts.frontend')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 col-sm-12 pricing-block">
                <div class="pricing-block-one active">
                    <div class="pricing-table">
                        <div class="table-header">
                            <h6>Pesanan Berhasil Dibuat</h6>
                            <p>Pesanan Anda Dengan Nominal </p>
                            <h2>Rp {{ formating_number($data->nominal,0) }}</h2>
                            <sub></sub>
                        </div>
                        <div class="table-body">
                            <p>Anda bisa bayar menggunakan bank transfer berikut:</p>
                            <table class="table">
                                <tr>
                                    <th>Bank</th>
                                    <th>Nomor Rekening</th>
                                    <th>Atas Nama</th>
                                </tr>
                                @forelse($data_bank as $bank)
                                <tr>
                                    <th>{{ $bank->bank }}</th>
                                    <th>{{ $bank->no_rekening }}</th>
                                    <th>{{ $bank->nama }}</th>
                                </tr>
                                @empty 
                                @endforelse
                            </table>
                           
                            <a href="{{ url('/data/order/'.$data->id.'/konfirmasi')}}" class="btn-1 w-100 text-center">Konfirmasi Pembayaran <i class="icon-arrow-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
