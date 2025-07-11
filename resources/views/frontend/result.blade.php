@extends('layouts.frontend')

@section('content')

<!-- Title -->
<section class="page-title-section" style="padding: 20px 0;">
    <div class="container">
        <div class="page-title-wrapper">
            <h3 class="page-title">Result & Certificate</h3>
        </div>
    </div>
</section>

<!-- Result Table -->
<section class="result-section" style="padding: 40px 0;">
    <div class="container">
        <div class="card">
            <div class="card-body table-responsive">
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
                        @forelse ($registrations as $index => $registration)
                            <tr>
                                <td>{{ $registrations->firstItem() + $index }}</td>
                                @php
    $scoreDate = optional($registration->score)->created_at;
    $certificateDate = optional($registration->certificate)->created_at;

    $earliestDate = collect([$scoreDate, $certificateDate])->filter()->sort()->first();
@endphp

<td>
    @if ($earliestDate)
        {{ $earliestDate->format('d M Y') }}
    @else
        <span class="text-muted">-</span>
    @endif
</td>

                                <td>{{ $registration->workshop->title ?? 'N/A' }}</td>
                                <td><span class="badge bg-success">Completed</span></td>
                                <td>
                                    @if ($registration->score)
                                        {{ $registration->score->score }}
                                    @else
                                        <span class="text-muted">No Score</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($registration->certificate)
                                        <span class="text-success">Available</span>
                                    @else
                                        <span class="text-muted">Not Available</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($registration->certificate)
                                        <a href="{{ route('download.certificate', $registration->id) }}" class="btn btn-sm btn-success">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                    @else
                                        <button class="btn btn-sm btn-secondary" disabled>
                                            <i class="fas fa-ban"></i> No Certificate
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="alert alert-warning mb-0">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        No completed workshops or results available.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $registrations->links() }}
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
