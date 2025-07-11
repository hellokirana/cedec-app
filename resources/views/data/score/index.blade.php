@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Student Scores</h4>

    <form method="GET" action="{{ route('score.index') }}" class="row g-3 mb-4">
        <div class="col-md-6">
            <label for="workshop_id" class="form-label">Filter by Workshop</label>
            <select name="workshop_id" class="form-select" onchange="this.form.submit()" required>
                <option value="">-- Choose Workshop --</option>
                @foreach($workshops as $workshop)
                    <option value="{{ $workshop->id }}" {{ request('workshop_id') == $workshop->id ? 'selected' : '' }}>
                        {{ $workshop->title }}
                    </option>
                @endforeach
            </select>
        </div>
        @if(request('workshop_id'))
        <div class="col-md-6 d-flex align-items-end justify-content-end">
            <a href="{{ route('score.upload', ['workshop_id' => request('workshop_id')]) }}" class="btn btn-success">
                <i class="fa fa-upload me-1"></i> Upload Scores
            </a>
        </div>
        @endif
    </form>

    @if(request('workshop_id'))
    <table class="table table-bordered table-striped" id="score-table">
        <thead>
            <tr>
                <th>#</th>
                <th>NPM</th>
                <th>Name</th>
                <th>Score</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>
            @forelse($registrations as $index => $reg)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $reg->user->npm }}</td>
                    <td>{{ $reg->user->name }}</td>
                    <td>{{ $reg->score?->score ?? '-' }}</td>
                    <td>{{ $reg->score?->updated_at?->format('d M Y H:i') ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No participants found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    @endif
</div>
@endsection
