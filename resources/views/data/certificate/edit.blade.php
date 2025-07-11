@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            Upload / Replace Certificate
        </div>
        <div class="card-body">
            <p><strong>Name:</strong> {{ $registration->user->name }}</p>
            <p><strong>NPM:</strong> {{ $registration->user->npm }}</p>

            @if($registration->certificate)
                <p>
                    <strong>Current Certificate:</strong><br>
                    <a href="{{ asset('storage/certificates/' . $registration->certificate->certificate) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                        View Certificate
                    </a>
                </p>
            @endif

            <form action="{{ route('certificate.update', $registration->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="certificate" class="form-label">New Certificate (PDF only)</label>
                    <input type="file" name="certificate" class="form-control" accept=".pdf" required>
                    @error('certificate') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-upload me-1"></i> Upload Certificate
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
