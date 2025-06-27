@extends('layouts.frontend')

@section('content')

<!-- title -->
<section class="page-title-section" style="padding: 20px 0;">
    <div class="container">
        <div class="page-title-wrapper">
            <h3 class="page-title">Workshops</h3>
        </div>
    </div>
</section>

<!-- Detail Section -->
<section class="py-5 bg-light">
    <div class="container">
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($data->status != 1)
            <div class="alert alert-warning">
                <i class="fa-solid fa-circle-exclamation me-2"></i>Registration is closed for this workshop.
            </div>
        @endif

        <div class="row g-4">
            <!-- Poster (Kiri) -->
            <div class="col-lg-4">
                <button type="button" class="btn p-0 w-100" data-bs-toggle="modal" data-bs-target="#posterModal">
                    <div class="ratio ratio-1x1 rounded overflow-hidden shadow-sm"
                        style="background-image: url('{{ $data->image_url }}');
                                background-size: cover;
                                background-position: center;">
                    </div>
                </button>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="posterModal" tabindex="-1" aria-labelledby="posterModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content position-relative bg-transparent border-0">
                <div class="modal-body p-0">
                    <img src="{{ $data->image_url }}" alt="Workshop Poster" class="img-fluid rounded shadow">
                </div>
                </div>
            </div>
            </div>

            <!-- Card Detail (Kanan) -->
            <div class="col-lg-8">
                <div class="bg-white rounded shadow-sm p-4 h-100 d-flex flex-column justify-content-between">
                    <div>
                        <h4 class="fw-bold">{{ $data->title }}</h4>
                        <p class="text-muted mb-1">
                            Register before: <strong>{{ \Carbon\Carbon::parse($data->registration_end_date)->format('d M Y') }}</strong> |
                            <strong>{{ $data->quota }} Participant left</strong>
                        </p>
                        <p class="mb-3">{{ $data->description }}</p>

                        <ul class="list-unstyled text-secondary small">
                            <li><i class="fa-solid fa-money-bill-wave me-2"></i>
                                {{ $data->fee == 0 ? 'Free' : 'Rp ' . number_format($data->fee, 0, ',', '.') }}
                            </li>
                            <li><i class="fa-solid fa-clock me-2"></i>{{ $data->time }} WIB</li>
                            <li><i class="fa-solid fa-calendar-days me-2"></i>
                                {{ \Carbon\Carbon::parse($data->workshop_start_date)->format('d M Y') }}
                                –
                                {{ \Carbon\Carbon::parse($data->workshop_end_date)->format('d M Y') }}
                            </li>
                            <li><i class="fa-solid fa-location-dot me-2"></i>{{ $data->place }}</li>
                        </ul>
                        @if($data->fee == 0)
                            @if($data->status == 1)
                                <form method="POST" action="{{ url('send_workshop_registration') }}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="workshop_id" value="{{ $data->id }}">
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary px-4">Register</button>
                                    </div>
                                </form>
                            @endif
                        @endif


                    </div>
                </div>
            </div>
        </div>

        <!-- Form Registrasi -->
        @if($data->fee > 0 && $data->status == 1)
<div class="bg-white mt-5 p-4 rounded shadow-sm">
    

    <form method="POST" action="{{ url('send_workshop_registration') }}" enctype="multipart/form-data">
       

        @csrf
        
        <input type="hidden" name="workshop_id" value="{{ $data->id }}">

        <div class="row mb-4">
            
            <div class="d-flex justify-content-between align-items-center mb-2">
        <h5 class="fw-semibold mb-0">Registration Form</h5>
        <div class="text-end">
            <span class="text-muted small">Please pay to the following account:</span><br>
            @foreach($banks as $bank)
                <strong class="text-dark d-block">{{ $bank->bank_number }}</strong>
                <span class="text-muted small">{{ $bank->bank }} - {{ $bank->name }}</span>
            @endforeach
        </div>
    </div>
            <div class="col-12">
                <div class="border rounded p-4 text-muted border-dashed d-flex align-items-center gap-4 flex-wrap" style="border-style: dashed;">
                    <i class="fa-solid fa-upload fa-2x"></i>
                    <div class="flex-grow-1">
                        <p class="mb-1">Upload your receipt of payment here</p>
                        <label class="btn btn-outline-secondary btn-sm mt-1">
                            Choose File
                            <input type="file" name="transfer_proof" id="transfer_proof" hidden required>
                        </label>
                        <!-- Tempat preview muncul -->
                        <div id="file-preview" class="mt-2 text-start small text-dark"></div>
@error('transfer_proof')
    <div class="text-danger mt-2 small">
        <i class="fa-solid fa-triangle-exclamation me-1"></i> {{ $message }}
    </div>
@enderror

                    </div>
                </div>
            </div>
            
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary px-4">Register</button>
        </div>

        @endif
    </form>
</div>

        </div>
    </div>
</section>
@endsection
