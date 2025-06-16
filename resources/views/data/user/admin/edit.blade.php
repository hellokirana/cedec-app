@extends('layouts.app')

@section('content')
<div class="container">
    <form method="POST" action="{{ url('data/admin',$data->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-capitalize">
                        Tambah admin
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <x-form.text label="Nama Lengkap" for="name" name="name"
                                    value="{{ $data->name }}" :error="$errors->first('name')" required></x-form.text>
                            </div>
                            <div class="col-md-6">
                                <x-form.email label="email" for="email" name="email"
                                    value="{{ $data->email }}" :error="$errors->first('email')" required></x-form.email>
                            </div>
                            <div class="col-md-6">
                                <x-form.password label="password" for="password" name="password"
                                     :error="$errors->first('password')"></x-form.password>
                            </div>
                            <div class="col-md-6">
                                <x-form.text label="no_telp" for="no_telp" name="no_telp"
                                    value="{{ $data->no_telp }}" :error="$errors->first('no_telp')" required></x-form.text>
                            </div>

                            <div class="col-md-12">
                                <x-form.text label="alamat" for="alamat" name="alamat"
                                    value="{{ $data->alamat }}" :error="$errors->first('alamat')" required></x-form.text>
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
                            <x-form.file label="image" for="image" name="image" data-default-file="{{ $data->avatar_url }}"
                                :error="$errors->first('image')"></x-form.file>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label>Status </label><br>
                            {{ Form::select('status', status_publish(), $data->status, ['class' => 'form-select']) }}
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
