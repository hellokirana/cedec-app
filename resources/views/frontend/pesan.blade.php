@extends('layouts.frontend')

@section('content')
    <section class="common-banner">
        <div class="bg-layer" style="background: url('{{ asset('assets/images/background/common-banner-bg.jpg') }}');"></div>
        <div class="common-banner-content">
            <h3>Pesan Layanan</h3>
            <div class="breadcrumb">
                <ul>
                    <li class="breadcrumb-item active"><a href="{{ url('/') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><i class="fa-solid fa-angles-right"></i> Pesan Layanan</li>
                </ul>
            </div>
        </div>
    </section>
    <section class=" service-details">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="common-title">
                        <h4>{{ $data->title}}</h4>

                    </div>
                    <div class="ratio ratio-16x9 mb-4"
                        style="background-image: url('{{ $data->image_url }}');background-repeat: no-repeat;
                        background-size: cover;">

                    </div>
                    <div class="service-details-content">
                        <h4>Service Details</h4>
                        {!! $data->konten !!}
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="contact-form">
                        <h3>Pesan Layanan</h3>
                        <form method="POST" action="{{ url('send_order') }}">
                            @csrf
                            <input type="hidden" name="layanan_id" value="{{ $data->id}}">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label>Tanggal Layanan</label>
                                    <input type="date" class="cmn-input" name="waktu" value="{{ old('waktu') }}"
                                        required placeholder="waktu Lengkap" min="{{date('Y-m-d')}}" max="{{date('Y-m-d', strtotime('+2 days'))}}">
                                </div>
                                <div class="col-lg-6">

                                    <div class="form-group mb-3">
                                        <label>Jam Layanan</label>
                                        {{ Form::select('jam', jam_layanan(), null, ['class' => 'form-select']) }}
                                        @if ($errors->first('jam'))
                                            <small class="text-danger text-capitalize">{{ $errors->first('jam') }}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label>Nomor Yang bisa di hubungi</label>
                                    <input type="text" class="cmn-input" name="no_telp" value="{{ Auth::user()->no_telp }}"
                                        required placeholder="+62 xxxx xxxx xxxx ">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <label for="province">Provinsi</label>
                                    <select name="province_code" id="province" class="form-control" required>
                                        <option value="">Pilih Provinsi</option>
                                        @foreach($provinces as $province)
                                            <option value="{{ $province->code }}" {{ $province->code == $user->province_code ? 'selected' : '' }}>
                                                {{ $province->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label for="city">Kota/Kabupaten</label>
                                    <select name="city_code" id="city" class="form-control" required>
                                        <option value="">Pilih Kota/Kabupaten</option>
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label for="district">Kecamatan</label>
                                    <select name="district_code" id="district" class="form-control" required>
                                        <option value="">Pilih Kecamatan</option>
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label for="village">Kelurahan/Desa</label>
                                    <select name="village_code" id="village" class="form-control" required>
                                        <option value="">Pilih Kelurahan/Desa</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <x-form.text label="RT" for="rt" name="rt"
                                        value="{{ Auth::user()->rt }}" :error="$errors->first('rt')" required></x-form.text>
                                </div>
                                <div class="col-md-6">
                                    <x-form.text label="RW" for="rw" name="rw"
                                        value="{{ Auth::user()->rw }}" :error="$errors->first('rw')" required></x-form.text>
                                </div>
                                <div class="col-md-12">
                                    <x-form.text label="Alamat" for="alamat" name="alamat"
                                        value="{{ Auth::user()->alamat }}" :error="$errors->first('alamat')" required></x-form.text>

                                    <div class="checkbox-input">
                                        <input type="checkbox" class="form-check-input" id="term" required>
                                        <label for="term">Data Yang saya kirim adalah data yang sebenarnya dari
                                            saya</label>
                                    </div>
                                    <button type="submit" class="btn-1">Pesan Sekarang<i class="icon-arrow-1"></i></button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Debug untuk memastikan jQuery dan event berjalan
    console.log('Document ready');

    // Fungsi untuk memuat data kota
    function loadCities(provinceCode, selectedCity = '') {
        console.log('Loading cities for province:', provinceCode); // Debug
        $.ajax({
            url: '{{ url("/") }}/get-cities/' + provinceCode,
            type: 'GET',
            success: function(data) {
                console.log('Cities response:', data); // Debug
                $('#city').empty();
                $('#city').append('<option value="">Pilih Kota/Kabupaten</option>');
                data.forEach(function(city) {
                    $('#city').append(`<option value="${city.code}" ${city.code == selectedCity ? 'selected' : ''}>${city.name}</option>`);
                });
            },
            error: function(xhr, status, error) {
                console.error('Error loading cities:', error);
                console.error('Status:', status);
                console.error('Response:', xhr.responseText);
            }
        });
    }

    // Fungsi untuk memuat data kecamatan
    function loadDistricts(cityCode, selectedDistrict = '') {
        console.log('Loading districts for city:', cityCode); // Debug
        $.ajax({
            url: '{{ url("/") }}/get-districts/' + cityCode,
            type: 'GET',
            success: function(data) {
                console.log('Districts response:', data); // Debug
                $('#district').empty();
                $('#district').append('<option value="">Pilih Kecamatan</option>');
                data.forEach(function(district) {
                    $('#district').append(`<option value="${district.code}" ${district.code == selectedDistrict ? 'selected' : ''}>${district.name}</option>`);
                });
            },
            error: function(xhr, status, error) {
                console.error('Error loading districts:', error);
            }
        });
    }

    // Fungsi untuk memuat data desa/kelurahan
    function loadVillages(districtCode, selectedVillage = '') {
        console.log('Loading villages for district:', districtCode); // Debug
        $.ajax({
            url: '{{ url("/") }}/get-villages/' + districtCode,
            type: 'GET',
            success: function(data) {
                console.log('Villages response:', data); // Debug
                $('#village').empty();
                $('#village').append('<option value="">Pilih Kelurahan/Desa</option>');
                data.forEach(function(village) {
                    $('#village').append(`<option value="${village.code}" ${village.code == selectedVillage ? 'selected' : ''}>${village.name}</option>`);
                });
            },
            error: function(xhr, status, error) {
                console.error('Error loading villages:', error);
            }
        });
    }

    // Event listener untuk perubahan provinsi
    $('#province').on('change', function() {
        const provinceCode = $(this).val();
        console.log('Province changed to:', provinceCode); // Debug
        if (provinceCode) {
            loadCities(provinceCode);
            $('#district').empty().append('<option value="">Pilih Kecamatan</option>');
            $('#village').empty().append('<option value="">Pilih Kelurahan/Desa</option>');
        }
    });

    // Event listener untuk perubahan kota
    $('#city').on('change', function() {
        const cityCode = $(this).val();
        console.log('City changed to:', cityCode); // Debug
        if (cityCode) {
            loadDistricts(cityCode);
            $('#village').empty().append('<option value="">Pilih Kelurahan/Desa</option>');
        }
    });

    // Event listener untuk perubahan kecamatan
    $('#district').on('change', function() {
        const districtCode = $(this).val();
        console.log('District changed to:', districtCode); // Debug
        if (districtCode) {
            loadVillages(districtCode);
        }
    });

    // Load data awal jika ada nilai yang tersimpan
    const initialProvinceCode = '{{ Auth::user()->province_code }}';
    const initialCityCode = '{{ Auth::user()->city_code }}';
    const initialDistrictCode = '{{ Auth::user()->district_code }}';
    const initialVillageCode = '{{ Auth::user()->village_code }}';

    console.log('Initial values:', {
        province: initialProvinceCode,
        city: initialCityCode,
        district: initialDistrictCode,
        village: initialVillageCode
    });

    if (initialProvinceCode) {
        loadCities(initialProvinceCode, initialCityCode);
    }
    if (initialCityCode) {
        loadDistricts(initialCityCode, initialDistrictCode);
    }
    if (initialDistrictCode) {
        loadVillages(initialDistrictCode, initialVillageCode);
    }
});
</script>
@endpush
