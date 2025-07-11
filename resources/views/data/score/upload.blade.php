@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Import Student Scores</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('score.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="workshop_id" class="form-label">Select Workshop</label>
            <select name="workshop_id" class="form-select" required>
                <option value="">-- Choose Workshop --</option>
                @foreach ($workshops as $workshop)
                    <option value="{{ $workshop->id }}">{{ $workshop->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="score_file" class="form-label">Upload Excel File (.xlsx)</label>
            <input type="file" name="score_file" class="form-control" accept=".xlsx" required>
            <small class="text-muted">Required columns: <strong>npm</strong>, <strong>score</strong></small>
        </div>

        <button type="submit" class="btn btn-primary"><i class="fa fa-upload me-2"></i>Import Scores</button>
    </form>
</div>
@endsection
