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

    <!-- newest workshop -->
    <section class="featured">
        <div class="container">
            <div class="common-title">
                <h6>SHOWING</h6>
                <h3>Workshop</h3>
            </div>
            <div class="row g-4">
                @forelse($workshop_all as $workshop)
                    <div class="col-lg-4 col-md-6">
                        <div class="featured-single">
                            <div class="featured-single-image">
                                <a href="{{ url('workshop/' . $workshop->id) }}">
                                    <img src="{{ $workshop->image_url }}" class="w-100"  alt="image">
                                </a>
                            </div>
                            <div class="featured-single-wishlist">
                                <h6>
                                    @switch($workshop->status)
                                        @case(1)
                                            <span class="text-success fw-bold">Registration Open</span>
                                            @break
                                        @case(2)
                                            <span class="text-warning fw-bold">Ongoing</span>
                                            @break
                                        @case(3)
                                            <span class="text-secondary fw-bold">Closed</span>
                                            @break
                                        @default
                                            <span class="text-muted fw-bold">Unknown</span>
                                    @endswitch
                                </h6>
                            </div>
                            <div class="featured-single-content">

                                <a href="{{ url('workshop/' . $workshop->id) }}">{{ $workshop->title }} </a>
                                <div class="featured-single-info">
                                    <div class="featured-single-info-left">
                                        <!-- Detail Info -->
                                        <div class="mt-2 text-secondary small">
                                            <div class="d-flex align-items-center mb-1">
                                                <i class="fa-solid fa-calendar-days me-2"></i>
                                                <span>
                                                    {{ \Carbon\Carbon::parse($workshop->workshop_start_date)->format('d M Y') }}
                                                    –
                                                    {{ \Carbon\Carbon::parse($workshop->workshop_end_date)->format('d M Y') }}
                                                </span>
                                            </div>

                                            <div class="d-flex align-items-center mb-1">
                                                <i class="fa-solid fa-clock me-2"></i>
                                                <span>{{ $workshop->time }} WIB</span>
                                            </div>

                                            <div class="d-flex align-items-center">
                                                <i class="fa-solid fa-location-dot me-2"></i>
                                                <span>{{ $workshop->place }}</span>
                                            </div>
                                        </div>

                                        <div class="featured-single-info mt-3">
                                            <div class="featured-single-info-left">
                                                <h6>
                                                    {{ $workshop->fee == 0 ? 'Free' : 'Rp ' . formating_number($workshop->fee, 0) }}
                                                </h6>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <a href="{{ url('workshop/' . $workshop->id) }}" class="btn-link-secondary">See details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-warning mt-4">
                        <div class="alert-body">
                            There are no workshops available
                        </div>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </section>
    <!-- featured -->

@endsection
