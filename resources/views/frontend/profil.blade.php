@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        {{-- Informasi Profil --}}
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Profil Saya</div>
                <div class="card-body">

                    <div class="mb-3">
                        <strong>Nama Lengkap:</strong><br>
                        {{ $data->name }}
                    </div>

                    <div class="mb-3">
                        <strong>Email:</strong><br>
                        {{ $data->email }}
                    </div>

                    @if($data->hasRole('student'))
                        <div class="mb-3">
                            <strong>NPM:</strong><br>
                            {{ $data->npm ?? '-' }}
                        </div>

                        <div class="mb-3">
                            <strong>Program Studi:</strong><br>
                            {{ $data->program->name ?? '-' }}
                        </div>
                    @endif

                    <div class="mb-3">
                        <strong>Status:</strong><br>
                        {{ $data->status ? 'Active' : 'Inactive' }}
                    </div>

                </div>
            </div>
        </div>


    </div>
</div>
@endsection
