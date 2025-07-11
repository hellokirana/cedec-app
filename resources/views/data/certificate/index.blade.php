@extends('layouts.app')

@section('content')
<div class="container">
    <h5 class="mb-3">Manage Certificates</h5>

    <form method="GET" class="mb-4">
        <label for="workshop_id">Select Workshop:</label>
        <select name="workshop_id" class="form-select" onchange="this.form.submit()">
            <option value="">-- Select Workshop --</option>
            @foreach($workshops as $workshop)
                <option value="{{ $workshop->id }}" {{ $selectedWorkshop == $workshop->id ? 'selected' : '' }}>
                    {{ $workshop->title }}
                </option>
            @endforeach
        </select>
    </form>

    @if ($registrations)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Participant</th>
                    <th>NPM</th>
                    <th>Certificate</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($registrations as $i => $reg)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $reg->user->name }}</td>
                        <td>{{ $reg->user->npm ?? '-' }}</td>
                        <td>
                            @if($reg->certificate)
                                <a href="{{ $reg->certificate->certificate_url }}" target="_blank">View</a>
                            @else
                                <span class="text-muted">Not uploaded</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex flex-column gap-2">
                                {{-- Form Upload --}}
                                <form action="{{ route('certificate.upload', $reg->id) }}" method="POST" enctype="multipart/form-data" class="d-flex gap-2">
                                    @csrf
                                    <input type="file" name="certificate" accept=".pdf,.jpg,.png" required class="form-control form-control-sm" style="width: 60%">
                                    <button class="btn btn-sm btn-primary">Upload</button>
                                </form>

                                {{-- Tombol Edit/Replace --}}
                                @if ($reg->certificate)
                                    <a href="{{ route('certificate.edit', $reg->id) }}" class="btn btn-sm btn-warning w-100">
                                        <i class="fa fa-edit me-1"></i> Edit
                                    </a>
                                @endif
                            </div>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
