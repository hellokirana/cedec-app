@extends('layouts.app')

@section('content')
<div class="container">
    <form method="POST" action="{{ url('update_profil') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-capitalize">
                        Profil
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if(Auth::user()->isWorker()) 
                            <div class="col-12">
                                <label for="category">Kategori</label>
                                <div class="form-control bg-light">{{ Auth::user()->kategori ? Auth::user()->kategori->title : 'Tidak ada kategori' }}</div>
                            </div>
                            @endif
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
                            @if(Auth::user()->hasRole('worker') || Auth::user()->hasRole('admin'))
                                <div class="col-md-6">
                                    <x-form.text label="Nomor Rekening" for="no_rekening" name="no_rekening"
                                        value="{{ old('no_rekening', $data->no_rekening) }}" :error="$errors->first('no_rekening')" required>
                                    </x-form.text>
                                </div>
                            @endif
                            <!-- Dropdown Provinsi -->
                            <div class="col-12">
                                <label for="province">Provinsi</label>
                                <select name="province_code" id="province" class="form-control" required>
                                    <option value="">Pilih Provinsi</option>
                                    @foreach($provinces as $province)
                                        <option value="{{ $province->code }}" {{ $province->code == Auth::user()->province_code ? 'selected' : '' }}>
                                            {{ $province->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Dropdown Kota -->
                            <div class="col-12">
                                <label for="city">Kota/Kabupaten</label>
                                <select name="city_code" id="city" class="form-control" required>
                                    <option value="">Pilih Kota/Kabupaten</option>
                                    
                                </select>
                            </div>

                            <!-- Dropdown Kecamatan -->
                            <div class="col-12">
                                <label for="district">Kecamatan</label>
                                <select name="district_code" id="district" class="form-control" required>
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                            </div>

                            <!-- Dropdown Kelurahan -->
                            <div class="col-12">
                                <label for="village">Kelurahan/Desa</label>
                                <select name="village_code" id="village" class="form-control" required>
                                    <option value="">Pilih Kelurahan/Desa</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <x-form.text label="RT" for="rt" name="rt"
                                    value="{{ $data->rt }}" :error="$errors->first('rt')" required></x-form.text>
                            </div>
                            <div class="col-md-6">
                                <x-form.text label="RW" for="rw" name="rw"
                                    value="{{ $data->rw }}" :error="$errors->first('rw')" required></x-form.text>
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