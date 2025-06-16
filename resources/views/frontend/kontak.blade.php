@extends('layouts.frontend')

@section('content')
    <!-- common banner -->
    <section class="common-banner">
        <div class="bg-layer" style="background: url('{{ asset('assets/images/background/common-banner-bg.jpg') }}');"></div>
        <div class="common-banner-content">
            <h3>Kontak Kami</h3>
            <div class="breadcrumb">
                <ul>
                    <li class="breadcrumb-item active"><a href="{{ url('/') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><i class="fa-solid fa-angles-right"></i> Kontak Kami</li>
                </ul>
            </div>
        </div>
    </section>
    <!-- common banner -->

    <!-- Info Kontak -->
    <section class="contact-details py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="contact-card h-100 p-4 rounded-lg shadow-sm text-center hover:shadow-md transition-all">
                        <div class="contact-icon mb-3">
                            <i class="fas fa-envelope fa-2x text-primary"></i>
                        </div>
                        <div class="contact-info">
                            <h5 class="mb-2">Email</h5>
                            <a href="mailto:dekat@solusicosmo.com" class="text-decoration-none">dekat@solusicosmo.com</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="contact-card h-100 p-4 rounded-lg shadow-sm text-center hover:shadow-md transition-all">
                        <div class="contact-icon mb-3">
                            <i class="fas fa-map-marker-alt fa-2x text-primary"></i>
                        </div>
                        <div class="contact-info">
                            <h5 class="mb-2">Alamat</h5>
                            <p class="mb-0">Jl. Margonda Raya No.54, Depok, Jawa Barat 16431</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- contact -->
    <section class="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="contact-left-container">
                        <div class="contact-image">
                            <img src="{{ asset('assets/images/resource/masukan.png') }}" alt="image">
                        </div>
                        <div class="contact-shape">
                            <img src="{{ asset('assets/images/shape/shape-3.png') }}" alt="image">
                        </div>
                        <div class="contact-left-blank"></div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="contact-form">
                        <h3>Kirim Masukan</h3>
                        @if (Session::has('success'))
                            <div class="mt-3 alert alert-success">
                                <div class="alert-body">Terima kasih sudah mengirimkan Pesan kepada kami</div>
                            </div>
                        @endif
                        @if (Session::has('warning'))
                            <div class="mt-3 alert alert-danger">
                                <div class="alert-body">Mohon Periksa kembali inputan anda</div>
                            </div>
                        @endif
                        <form method="POST" action="{{ url('send_kontak') }}">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <input type="text" class="cmn-input" name="nama" value="{{old('nama')}}" required
                                        placeholder="Nama Lengkap">
                                </div>
                                <div class="col-lg-6">
                                    <input type="email" class="cmn-input" name="email" value="{{old('email')}}" required
                                        placeholder="Email Anda">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <input type="text" class="cmn-input" name="subjek" value="{{old('subjek')}}" required placeholder="subjek">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <textarea class="cmn-input" name="pesan" required>{{old('pesan','Masukan Pesan anda disini')}}</textarea>
                                    <div class="checkbox-input">
                                        <input type="checkbox" class="form-check-input" id="term" required>
                                        <label for="term">Data Yang saya kirim adalah data yang sebenarnya dari
                                            saya</label>
                                    </div>
                                    <button type="submit" class="btn-1">Kirim <i class="icon-arrow-1"></i></button>
                                </div>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- contact -->


    <!-- contact map -->
    <section class="contact-map">
        <div class="container">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3964.9918022898955!2d106.8184317758929!3d-6.395057193595509!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69ec08612d8bed%3A0x567fbca52b1b6f8c!2sDisNakerSos%20Kota%20Depok!5e0!3m2!1sid!2sid!4v1736418981646!5m2!1sid!2sid"
                width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </section>
    <!-- contact map -->
@endsection
