@extends('layouts.frontend')

@section('content')
    <!-- banner-section -->
    <section class="banner-section-one ">
        <div class="bg-layer" style="background-image: url({{ asset('assets/images/banner/banner-1-bg.jpg') }});">
        </div>
        <div class="banner-line-shape">
            <img src="{{ asset('assets/images/shape/banner-line-shape.png') }}" alt="shape">
        </div>
        <div class="container">
            <div class="swiper-container">
                <div class="swiper single-item-carousel">
                    <div class="swiper-wrapper">
                        @forelse($slider_all as $slider)
                            <div class="swiper-slide testimonial-slider-item">
                                <a href="{{ $slider->link }}" target="_blank">
                                    <img src="{{ $slider->image_url }}" class="w-100">
                                </a>
                            </div>



                        @empty
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Categories -->
    <section class="categories">
        <div class="container">
            <div class="common-title-container">
                <div class="common-title mb-0">
                    <img src="{{ asset('assets/images/shape/title-shape-1.png') }}" alt="shape">
                    <h3>Kategori</h3>
                </div>
                <a href="{{ url('layanan') }}" class="btn-1">Selengkapnya <i class="icon-arrow-1"></i></a>
            </div>
            <div class="row">
                @forelse($kategori_all as $kategori)
                    <div class="col-lg-3 col-md-6">
                        <div class="categories-single">
                            <div class="categories-single-image">
                                <a href="{{ url('layanan') }}?kategori={{ $kategori->id }}">
                                    <img src="{{ $kategori->image_url }}" class="w-100" alt="{{ $kategori->title }}">
                                </a>
                            </div>
                            <div class="categories-single-title">
                                <a href="{{ url('layanan') }}?kategori={{ $kategori->id }}">{{ $kategori->title }}</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p>Tidak ada kategori yang tersedia.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    <!-- Categories -->


    <!-- services -->
    <section class="services">
        <div class="container">
            <div class="services-container">
                <div class="common-title text-center">
                    <h6><i class="fa-solid fa-angles-right"></i> BAGAIMANA CARA KERJANYA</h6>
                    <h3>Akses Layanan yang Mudah</h3>
                    <p></p>
                </div>
                <div class="services-one-wrapper">
                    <div class="services-one-wrapper-shape">
                        <img src="{{ asset('assets/images/shape/arrow-line.png') }}" alt="shape">
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="service-single">
                                <div class="service-number">
                                    <h3>01</h3>
                                </div>
                                <div class="service-icon">
                                    <img src="{{ asset('assets/images/icons/service-01.png') }}" alt="icon">
                                </div>
                                <div class="service-single-title">
                                    <a href="{{ url('layanan') }}">Pilih Layanan Anda</a>
                                    <p>Pilih layanan yang Anda cari - dari website</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="service-single">
                                <div class="service-number">
                                    <h3>02</h3>
                                </div>
                                <div class="service-icon">
                                    <img src="{{ asset('assets/images/icons/service-02.png') }}" alt="icon">
                                </div>
                                <div class="service-single-title">
                                    <a href="{{ url('layanan') }}">Pilih Jadwal Anda</a>
                                    <p>Pilih Jadwal layanan yang Anda butuhkan</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="service-single">
                                <div class="service-number">
                                    <h3>03</h3>
                                </div>
                                <div class="service-icon">
                                    <img src="{{ asset('assets/images/icons/service-03.png') }}" alt="icon">
                                </div>
                                <div class="service-single-title">
                                    <a href="{{ url('layanan') }}">Proses Layanan</a>
                                    <p>Layanan untuk anda kami siapkan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- services -->

    <!-- featured -->
    <section class="featured">
        <div class="container">
            <div class="common-title">
                <img src="{{ asset('assets/images/shape/title-shape-1.png') }}" alt="shape">
                <h6>DITAMPILKAN</h6>
                <h3>Layanan Terpopuler</h3>
            </div>
            <div class="row g-4">
                @forelse($layanan_all as $layanan)
                    <div class="col-lg-4 col-md-6">
                        <div class="featured-single">
                            <div class="featured-single-image">
                                <a href="{{ url('layanan/' . $layanan->id) }}">
                                    <img src="{{ $layanan->image_url }}" class="w-100"  alt="image">
                                </a>
                            </div>
                            <div class="featured-single-wishlist">
                                <h6>{{ @$layanan->kategori->title}}</h6>
                            </div>
                            <div class="featured-single-content">

                                <a href="{{ url('layanan/' . $layanan->id) }}">{{ $layanan->title }} </a>
                                <div class="featured-single-info">
                                    <div class="featured-single-info-left">
                                        <h5>Rp.{{ formating_number($layanan->harga_member, 0) }}</h5>
                                    </div>
                                    <a href="{{ url('pesan/' . $layanan->id) }}">Pesan Sekarang</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse
            </div>
        </div>
    </section>
    <!-- featured -->

    <!-- counter -->
    <section class="counter">
        <div class="container">
            <div class="counter-container">
                <div class="counter-shape-1"><img src="{{ asset('assets/images/shape/counter-1.png') }}" alt="shape">
                </div>
                <div class="counter-shape-2"><img src="{{ asset('assets/images/shape/counter-2.png') }}" alt="shape">
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="counter-single">
                            <div class="counter-single-inner">
                                <div class="odometer-box">
                                    <h2 class="odometer" data-count="52">00</h2>
                                    <h2 class="odometer-text">k</h2>
                                </div>
                                <h5>Customers</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="counter-single">
                            <div class="counter-single-inner">
                                <div class="odometer-box">
                                    <h2 class="odometer" data-count="42">00</h2>
                                    <h2 class="odometer-text">k</h2>
                                </div>
                                <h5>Reviews</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="counter-single">
                            <div class="counter-single-inner">
                                <div class="odometer-box">
                                    <h2 class="odometer" data-count="2">00</h2>
                                    <h2 class="odometer-text">M</h2>
                                </div>
                                <h5>Task Done</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="counter-single">
                            <div class="counter-single-inner">
                                <div class="odometer-box">
                                    <h2 class="odometer" data-count="3">00</h2>
                                    <h2 class="odometer-text">k</h2>
                                </div>
                                <h5>Jobs</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- counter -->


    <!-- testimonial -->
    <section class="testimonial">
        <div class="container">
            <div class="testimonial-container">
                <div class="testimonial-bg-shape">
                    <img src="{{ asset('assets/images/shape/testimonial-bg-shape.png') }}" alt="shape">
                </div>
                <div class="common-title text-center">
                    <img src="{{ asset('assets/images/shape/title-shape-1.png') }}" alt="shape">
                    <h6>TESTIMONIAL</h6>
                    <h3>Cerita Kami Melalui Ulasan Pelanggan</h3>
                </div>

                <div class="testimonial-carousel">
                    <div class="swiper-container">
                        <div class="swiper single-item-carousel">
                            <div class="swiper-wrapper">


                                @forelse($testimoni_all as $testimoni)
                                    <div class="swiper-slide testimonial-slider-item">
                                        <div class="testimonial-slider-single">
                                            <div class="testimonial-slider-image">
                                                <img src="{{ $testimoni->image_url }}" alt="{{ $testimoni->nama }}">
                                            </div>
                                            <div class="testimonial-slider-content">
                                                <div class="rating">
                                                    <ul>
                                                        @for ($i = 0; $i < $testimoni->rating; $i++)
                                                            <li><i class="fa-sharp fa-solid fa-star"></i></li>
                                                        @endfor
                                                        <li>{{ $testimoni->rating }}</li>
                                                    </ul>
                                                </div>
                                                <div class="testimonial-comments">
                                                    <p>
                                                        {{ $testimoni->konten }}
                                                    </p>
                                                </div>
                                                <div class="testimonial-info-box">
                                                    <div class="testimonial-info">
                                                        <h5>{{ $testimoni->nama }}</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                @endforelse


                            </div>
                        </div>
                    </div>
                    <div class="swiper-button-next"><i class="fa-regular fa-angle-right"></i></div>
                    <div class="swiper-button-prev"><i class="fa-sharp fa-regular fa-angle-left"></i></div>
                </div>
            </div>
        </div>
    </section>
    <!-- testimonial -->
@endsection
