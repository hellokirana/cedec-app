@extends('layouts.app')

@section('content')
<div class="container">
    <form method="POST" action="{{ url('data/worker') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-capitalize">
                        Tambah worker
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <x-form.text label="Nama Lengkap" for="name" name="name"
                                    value="{{ old('name') }}" :error="$errors->first('name')" required></x-form.text>
                            </div>
                            <div class="col-md-6">
                                <x-form.email label="email" for="email" name="email"
                                    value="{{ old('email') }}" :error="$errors->first('email')" required></x-form.email>
                            </div>
                            <div class="col-md-6">
                                <x-form.password label="password" for="password" name="password"
                                    value="{{ old('password') }}" :error="$errors->first('password')" required></x-form.password>
                            </div>
                            <div class="col-md-6">
                                <x-form.text label="no_telp" for="no_telp" name="no_telp"
                                    value="{{ old('no_telp') }}" :error="$errors->first('no_telp')" required></x-form.text>
                            </div>
                            <div class="col-md-6">
                                <x-form.text label="Nomor Rekening" for="no_rekening" name="no_rekening"
                                    value="{{ old('no_rekening') }}" :error="$errors->first('no_rekening')" required></x-form.text>
                            </div> 
                            <div class="col-md-6">
                                <x-form.number label="wallet" for="wallet" name="wallet"
                                    value="{{ old('wallet') }}" :error="$errors->first('wallet')" required></x-form.number>
                            </div>
                            <div class="col-md-12">
                                <x-form.text label="alamat" for="alamat" name="alamat"
                                    value="{{ old('alamat') }}" :error="$errors->first('alamat')" required></x-form.text>
                            </div>
                            <div class="col-md-6">
                                <label for="kategori_id">Pilih Kategori</label>
                                <select name="kategori_id" id="kategori_id" class="form-select" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}">{{ $kategori->title }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->first('kategori_id'))
                                    <small class="text-danger text-capitalize">{{ $errors->first('kategori_id') }}</small>
                                @endif
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
                            <x-form.file label="image" for="image" name="image" value="{{ old('image') }}"
                                :error="$errors->first('image')"></x-form.file>
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
