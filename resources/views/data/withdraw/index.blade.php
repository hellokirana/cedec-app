@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header d-md-flex justify-content-between text-capitalize">
                Manage withdraw
                @if (Auth::user()->getRoleNames()[0] == 'worker')
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addWithdraw">
                        Add withdraw
                    </button>
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    {{ $dataTable->table() }}
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addWithdraw" tabindex="-1" aria-labelledby="addWithdraw" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="{{ url('data/withdraw') }}" enctype="multipart/form-data">
                    @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addWithdraw">Add withdraw</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-12">
                        <x-form.number label="nominal" for="nominal" name="nominal" min=0 max="{{ Auth::user()->wallet }}"
                            value="{{ old('nominal') }}" :error="$errors->first('nominal')" required></x-form.number>
                        wallet anda : {{ formating_number(Auth::user()->wallet,0) }}
                    </div>
                    <div class="form-group">
                        <label>transfer ke Bank</label>
                        <select name="bank" class="cmn-input form-select" required>
                            @forelse(list_bank() as $listbank)
                                <option value="{{ $listbank }}">{{ $listbank }}
                                </option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div class="col-md-12">
                        <x-form.text label="no_rekening" for="no_rekening" name="no_rekening"  value="{{ old('no_rekening') }}" :error="$errors->first('no_rekening')" required></x-form.text>
                    </div>
                    <div class="col-md-12">
                        <x-form.text label="atas nama" for="nama" name="nama"  value="{{ old('nama') }}" :error="$errors->first('nama')" required></x-form.text>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
