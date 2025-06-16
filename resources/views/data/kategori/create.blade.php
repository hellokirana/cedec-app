@extends('layouts.app')

@section('content')
<div class="container">
    <form method="POST" action="{{ url('data/kategori') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-capitalize">
                        Tambah kategori
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <x-form.text label="Nama kategori" for="title" name="title"
                                    value="{{ old('title') }}" :error="$errors->first('title')" required></x-form.text>
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
