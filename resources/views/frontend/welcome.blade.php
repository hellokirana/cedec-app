@extends('layouts.frontend')

@section('content')

    <!-- Hero Section -->
    <section class="hero-section py-5" style="background: linear-gradient(to right, #ffffff, #ff9365);">
        <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between">
            <div class="hero-text mb-4 mb-md-0" style="max-width: 500px;">
                <h1 class="fw-bold mb-3" style="font-size: 2.5rem;">Empower Your Skills<br>with CEdEC Workshops.</h1>
                <p class="text-muted mb-4">Join a series of hands-on workshops designed to boost your professional and digital skills. Whether you're a beginner or looking to deepen your expertise, CEdEC welcomes you to grow, learn, and collaborate with industry practitioners.</p>
                <a href="{{ url('/workshop') }}" class="btn btn-primary px-4">View Workshop</a>
            </div>
            <div class="hero-image text-center">
                <img src="{{ asset('assets/images/logo-illustration.png') }}" alt="logo Illustration" class="img-fluid" style="max-height: 350px;">
            </div>
        </div>
    </section>
    <!-- End Hero Section -->

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
                                        @case(4)
                                            <span class="text-warning fw-bold">Upcoming</span>
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
