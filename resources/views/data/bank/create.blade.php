@extends('layouts.app')

@section('content')
<div class="container">
    <form method="POST" action="{{ url('data/bank') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-capitalize">
                        Tambah bank
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <x-form.text label="Nama" for="nama" name="nama"
                                    value="{{ old('nama') }}" :error="$errors->first('nama')" required></x-form.text>
                            </div>
                            <div class="col-12">
                                <x-form.text label="bank" for="bank" name="bank"
                                    value="{{ old('bank') }}" :error="$errors->first('bank')" required></x-form.text>
                            </div>
                            <div class="col-12">
                                <x-form.text label="no_rekening" for="no_rekening" name="no_rekening"
                                    value="{{ old('no_rekening') }}" :error="$errors->first('no_rekening')" required></x-form.text>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header text-capitalize">
                        Info data
                    </div>
                    <div class="card-body">
                        
                        <div class="mb-3">
                            <x-form.number label="no_urut" for="no_urut" name="no_urut" 
                            value="{{ old('no_urut') }}" min=1 :error="$errors->first('no_urut')" required></x-form.number>
                        </div>
                        
                        
                        
                        <div class="form-group mb-3">
                            <label>Status </label><br>
                            {{ Form::select('status', status_publish(), null, ['class' => 'form-select']) }}
                            @if ($errors->first('status'))
                                <small class="text-danger text-capitalize">{{ $errors->first('status') }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary "><i
                                class="fa fa-save me-2"></i>Simpan</button>
                    </div>
                </div>
            </div>
            
        </div>
    </form>
</div>
@endsection
