@extends('layouts.frontend')

@section('content')
<div class="container py-4">
    <div class="row">

        {{-- Profile Information --}}
        <div class="col-md-8 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white fw-bold">
                    Student Profile
                </div>
                <div class="card-body">

                    <div class="mb-3">
                        <strong>Full Name:</strong><br>
                        {{ $user->name }}
                    </div>

                    <div class="mb-3">
                        <strong>Email:</strong><br>
                        {{ $user->email }}
                    </div>

                    <div class="mb-3">
                        <strong>Student ID (NPM):</strong><br>
                        {{ $user->npm ?? '-' }}
                    </div>

                    <div class="mb-3">
                        <strong>Study Program:</strong><br>
                        {{ optional($user->program)->title ?? '-' }}
                    </div>

                </div>
            </div>
        </div>

        {{-- Avatar --}}
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm text-center">
                <div class="card-header bg-white fw-bold">
                    Profile Picture
                </div>
                <div class="card-body">
                    @if($user->avatar)
<img 
    src="{{ asset('storage/avatars/' . $user->avatar) }}" 
    class="mb-3 rounded" 
    style="width: 150px; height: 150px; object-fit: cover;"
>
                    @else
<img 
    src="{{ asset('default-avatar.png') }}" 
    class="mb-3 rounded" 
    style="width: 150px; height: 150px; object-fit: cover;"
>
                    @endif

                    {{-- Form upload avatar --}}
                    <form action="{{ route('student.profile.avatar.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')

                        <div class="form-group">
                            <input type="file" name="avatar" accept="image/*" class="form-control mb-2" required>
                            @error('avatar') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <button type="submit" class="btn btn-sm btn-primary">
                            <i class="fa fa-upload me-1"></i> Upload New Photo
                        </button>
                    </form>
                </div>
            </div>
        </div>


    </div>
</div>
@endsection
