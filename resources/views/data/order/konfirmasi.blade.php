@extends('layouts.frontend')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-6 col-sm-12 pricing-block">
                <form method="POST" action="{{ url('data/order/' . $data->id . '/send_konfirmasi') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="pricing-block-one active">
                        <div class="pricing-table">
                            <div class="table-header">
                                <h6>Konfirmasi Pembayaran Pesanan</h6>
                                <p>Nama Layanan : {{ @$data->layanan->title }}</p>
                                <p>Nominal :</p>
                                <h2>Rp {{ formating_number($data->nominal, 0) }}</h2>
                                <sub></sub>
                            </div>
                            <div class="table-body">
                                <div class="form-group">
                                    <label>Dari Bank</label>
                                    <select name="dari_bank" class="cmn-input form-select" required>
                                        @forelse(list_bank() as $listbank)
                                            <option value="{{ $listbank }}">{{ $listbank }}
                                            </option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Transfer Ke Bank</label>
                                    <select name="bank_id" class="cmn-input form-select" required>
                                        @forelse($data_bank as $bank)
                                            <option value="{{ $bank->id }}">{{ $bank->nama . ' ' . $bank->no_rekening }}
                                            </option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Jumlah Transfer</label>
                                    <input type="number" name="nominal_transfer" class="cmn-input" value="{{ $data->nominal}}">
                                </div>
                                <div class="form-group">
                                    <label>Bukti Transfer</label>
                                    <input type="file" name="bukti_transfer" class="cmn-input" accept="image/*">
                                </div>

                                <button type="submit" class="btn-1 w-100 text-center">Konfirmasi Pembayaran <i
                                        class="icon-arrow-1"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
