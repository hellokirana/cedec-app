@extends('layouts.frontend')

@section('content')
    <!-- common banner -->
    <section class="common-banner">
        <div class="bg-layer" style="background: url('{{ asset('assets/images/background/common-banner-bg.jpg') }}');"></div>
        <div class="common-banner-content">
            <h3>{{ $data->title}}</h3>
            <div class="breadcrumb">
                <ul>
                    <li class="breadcrumb-item active"><a href="{{ url('/') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><i class="fa-solid fa-angles-right"></i> Detail Layanan</li>
                </ul>
            </div>
        </div>
    </section>
    <!-- common banner -->


    <!-- service details -->
    <section class="service-details">
        <div class="container">
            <div class="common-title">
                <h3>{{ $data->title}}</h3>

            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="ratio ratio-16x9 mb-4" style="background-image: url('{{ $data->image_url}}');background-repeat: no-repeat;
    background-size: cover;">
                        
                    </div>
                    <div class="service-details-content">
                        <h4>Service Details</h4>
                        {!! $data->konten !!}
                    </div>
                </div>

                <div class="col-lg-4">
                    

                    <div class="service-package">
                        <div class="service-package-name">
                            <div class="package-name">
                                <h5>Harga Layanan</h5>
                                <h5>Rp.{{ formating_number($data->harga_member,0)}}</h5>
                            </div>
                        </div>
                        <div class="service-package-book">
                            <a href="{{ url('pesan/'.$data->id)}}" class="btn-1 w-100">Booking Sekarang</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- service details -->


    <!-- service 2 -->
    <section class="service-two pt-0" style="background-color: transparent;">
        <div class="container">
            <div class="common-title">
                <h6><i class="fa-solid fa-angles-right"></i> Layanan Lainnya </h6>
            </div>

            <div class="row">
                @forelse ($data_related as $related)
                    <div class="col-lg-3 col-md-6">
                        <div class="featured-single">
                            <div class="featured-single-image">
                                <a href="{{ url('layanan/' . $related->id) }}">
                                    <img src="{{ $related->image_url }}" class="w-100" alt="image">
                                </a>
                            </div>
                            <div class="featured-single-wishlist">
                                <h6>{{ @$related->kategori->title}}</h6>
                            </div>
                            <div class="featured-single-content">

                                <a href="{{ url('layanan/' . $related->id) }}">{{ $related->title }} </a>
                                <div class="featured-single-info">
                                    <div class="featured-single-info-left">
                                        <h5>Rp.{{ formating_number($related->harga_member, 0) }}</h5>
                                    </div>
                                    <a href="{{ url('pesan/' . $related->id) }}">Pesan Sekarang</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse
            </div>
        </div>
    </section>
    <!-- service 2 -->
@endsection
