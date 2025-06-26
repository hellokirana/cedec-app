@extends('layouts.frontend')

@section('content')

<!-- title -->
<section class="page-title-section" style="padding: 20px 0;">
    <div class="container">
        <div class="page-title-wrapper">
            <h3 class="page-title">Result & Certificate</h3>
        </div>
    </div>
</section>

<!-- Result & Certificate Content -->
<section class="result-section" style="padding: 40px 0;">
    <div class="container">

        <!-- Summary Statistics -->
        <div class="summary-stats mb-4">
            <div class="row">
                <div class="col-md-4">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Total Workshops</h6>
                                    <h4>{{ $registrations->total() }}</h4>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-chalkboard-teacher fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Certificates</h6>
                                    <h4>{{ $registrations->whereNotNull('certificate')->count() }}</h4>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-certificate fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Avg Score</h6>
                                    <h4>
                                        @php
                                            $avgScore = $registrations->where('average_score', '>', 0)->avg('average_score');
                                        @endphp
                                        {{ $avgScore ? round($avgScore, 1) : '0' }}
                                    </h4>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-chart-line fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Results Table -->
        <div class="results-wrapper">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Date</th>
                                    <th>Workshop</th>
                                    <th>Status</th>
                                    <th>Score</th>
                                    <th>Certificate</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($registrations->count() > 0)
                                    @foreach($registrations as $index => $registration)
                                        <tr>
                                            <td>{{ $registrations->firstItem() + $index }}</td>
                                            <td>
                                                @if($registration->scores && $registration->scores->count() > 0)
                                                    {{ \Carbon\Carbon::parse($registration->scores->first()->created_at)->format('d M Y') }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="workshop-info">
                                                    <h6 class="mb-0">{{ $registration->workshop->title ?? 'N/A' }}</h6>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">Completed</span>
                                            </td>
                                            <td>
                                                @if($registration->score !== 0)
                                                    <div class="score-display">
                                                        <span class="score-value">
                                                            {{ $registration->average_score }}
                                                        </span>
                                                    </div>
                                                @else
                                                    <span class="text-muted">No Score yet</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($registration->certificate)
                                                    <div class="certificate-status">
                                                        <i class="fas fa-certificate text-success"></i>
                                                        <span class="text-success ms-1">Available</span>
                                                    </div>
                                                @else
                                                    <div class="certificate-status">
                                                        <i class="fas fa-times-circle text-muted"></i>
                                                        <span class="text-muted ms-1">Not Available</span>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                @if($registration->certificate)
                                                    <a href="{{ route('download.certificate', $registration->id) }}" 
                                                       class="btn btn-sm btn-success" 
                                                       title="Download Certificate">
                                                        <i class="fas fa-download"></i> Download
                                                    </a>
                                                @else
                                                    <button class="btn btn-sm btn-secondary" disabled>
                                                        <i class="fas fa-ban"></i> No Certificate
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div class="alert alert-warning mb-0">
                                                <i class="fas fa-exclamation-triangle"></i> 
                                                No workshop certificate results found. You haven't completed any workshops yet.
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($registrations->count() > 0)
                        <div class="d-flex justify-content-center mt-4">
                            {{ $registrations->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@endsection