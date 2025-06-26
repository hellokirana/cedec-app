@extends('layouts.frontend')

@section('content')

    <!-- title -->
    <section class="page-title-section" style="padding: 20px 0;">
        <div class="container">
            <div class="page-title-wrapper">
                <h3 class="page-title">My Workshops</h3>
            </div>
        </div>
    </section>

    <!-- Search Section -->
<section class="search-section py-4">
    <div class="container">
        <form action="{{ url('workshop') }}" method="GET">
            <div class="d-flex justify-content-center flex-wrap gap-2">

                <!-- Keyword Search -->
                <input type="text" name="search" value="{{ request('search') }}" 
                    class="form-control" placeholder="Find a workshop"
                    style="min-width: 220px; max-width: 300px;">

                <!-- Status Dropdown -->
                <select name="status" class="form-select" style="width: 180px;">
                    <option value="">All Status</option>
                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Registration Open</option>
                    <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Ongoing</option>
                    <option value="3" {{ request('status') == '3' ? 'selected' : '' }}>Completed</option>
                </select>

                <!-- Fee Dropdown -->
                <select name="fee" class="form-select" style="width: 150px;">
                    <option value="">All Fee</option>
                    <option value="free" {{ request('fee') == 'free' ? 'selected' : '' }}>Free</option>
                    <option value="paid" {{ request('fee') == 'paid' ? 'selected' : '' }}>Paid</option>
                </select>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary" style="width: 100px;">
                    Search
                </button>
            </div>
        </form>
    </div>
</section>

<!-- service page -->
<section class="service-page">
    <div class="container">
        <div class="row justify-content-center">
            <!-- Service List -->
            <div class="col-lg-12">
                <div class="service-item-container">
                    <div class="row justify-content-center">
                        @forelse($registrations as $registration)
                        @php $workshop = $registration->workshop; @endphp
                            <div class="col-lg-3 col-md-6 mb-4 d-flex">
                                <div class="featured-single w-100">
                                    <div class="featured-single-image">
                                        <a href="{{ url('workshop/' . $workshop->id) }}">
                                            <img src="{{ $workshop->image_url }}" class="w-100" alt="{{ $workshop->title }}">
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
                                        <a href="{{ url('workshop/' . $workshop->id) }}">{{ $workshop->title }}</a>

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
                                            <a href="{{ url('workshop/' . $workshop->id) }}" class="btn-link-secondary">See details</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-warning mt-4">
                                    <div class="alert-body">
                                        The data you are looking for was not found
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="row mt-4 justify-content-center">
                        <div class="col-auto">
                            {{ $registrations->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection