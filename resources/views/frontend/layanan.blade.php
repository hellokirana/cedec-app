@extends('layouts.frontend')

@section('content')
    <!-- common banner -->
    <section class="common-banner">
        <div class="bg-layer" style="background: url('assets/images/background/common-banner-bg.jpg');"></div>
        <div class="common-banner-content">
            <h3>Layanan kami</h3>
            <div class="breadcrumb">
                <ul>
                    <li class="breadcrumb-item active"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><i class="fa-solid fa-angles-right"></i> Layanan</li>
                </ul>
            </div>
        </div>
    </section>
    <!-- common banner -->

    <!-- service page -->
    <section class="service-page">
        <div class="container">
            <div class="row">
                <!-- Sidebar Filter -->
                <div class="col-lg-3">
                    <form action="{{ url('layanan') }}" method="GET">
                        <div class="sidebar">
                            <div class="sidebar-top-title">
                                <h4>Filter by</h4>
                            </div>
                        </div>

                        <!-- Search Box -->
                        <div class="sidebar-box">
                            <div class="sidebar-title">
                                <h5>Cari</h5>
                            </div>
                            <div class="keyword-input">
                                <input type="text" name="cari" value="{{ $cari }}" placeholder="Tukang AC">
                            </div>
                        </div>

                        <!-- Categories Filter -->
                        <div class="sidebar-box">
                            <div class="categories-content sidebar-title">
                                <h5>
                                    <button class="btn" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#categoryCollapse" aria-expanded="true"
                                        aria-controls="categoryCollapse">
                                        <span>Kategori</span><i class="fa-regular fa-angle-down"></i>
                                    </button>
                                </h5>
                                <div class="collapse show" id="categoryCollapse">
                                    <div class="card card-body">
                                        <div class="categories-list">
                                            <ul>
                                                @forelse($kategori_all as $kat)
                                                    <li>
                                                        <div class="checkbox-input">
                                                            <input type="checkbox" class="form-check-input"
                                                                name="kategori" value="{{ $kat->id }}"
                                                                id="kategori_{{ $kat->id }}"
                                                                {{ $kategori == $kat->id ? 'checked' : '' }}>
                                                            <label for="kategori_{{ $kat->id }}">{{ $kat->title }}</label>
                                                        </div>
                                                    </li>
                                                @empty
                                                    <li class="text-center">Tidak ada kategori tersedia</li>
                                                @endforelse
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Filter Button -->
                        <div class="sidebar-button">
                            <button type="submit" class="btn-1 w-100">
                                <i class="fa-solid fa-magnifying-glass"></i> Cari Sekarang
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Service List -->
                <div class="col-lg-9">
                    <div class="service-item-container">
                        <div class="row">
                            @forelse($layanan_all as $layanan)
                                <div class="col-lg-4 col-md-6">
                                    <div class="featured-single">
                                        <div class="featured-single-image">
                                            <a href="{{ url('layanan/' . $layanan->id) }}">
                                                <img src="{{ $layanan->image_url }}" class="w-100" alt="{{ $layanan->title }}">
                                            </a>
                                        </div>
                                        <div class="featured-single-wishlist">
                                            <h6>{{ @$layanan->kategori->title }}</h6>
                                        </div>
                                        <div class="featured-single-content">
                                            <a href="{{ url('layanan/' . $layanan->id) }}">{{ $layanan->title }}</a>
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
                                <div class="col-12">
                                    <div class="alert alert-warning mt-4">
                                        <div class="alert-body">
                                            Data yang Anda cari tidak ditemukan
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                        </div>

                        <!-- Pagination -->
                        <div class="row mt-4">
                            <div class="col-12">
                                {{ $layanan_all->appends(['kategori' => $kategori, 'cari' => $cari])->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection