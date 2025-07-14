@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="mb-0">Workshop Management Dashboard</h3>
            <p class="text-muted">Overview of workshop activities and statistics</p>
        </div>
    </div>

    {{-- Main Statistics Cards --}}
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 50px; height: 50px;">
                                <i class="ri-book-2-line text-white fs-5"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1 text-muted">Total Workshops</h6>
                            <h3 class="mb-0 text-primary">{{ $totalWorkshops }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 50px; height: 50px;">
                                <i class="ri-user-3-line text-white fs-5"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1 text-muted">Total Participants</h6>
                            <h3 class="mb-0 text-success">{{ $totalParticipants }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 50px; height: 50px;">
                                <i class="ri-play-circle-line text-white fs-5"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1 text-muted">Ongoing Workshops</h6>
                            <h3 class="mb-0 text-warning">{{ $ongoingWorkshops }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 50px; height: 50px;">
                                <i class="ri-calendar-check-line text-white fs-5"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1 text-muted">Completed Workshops</h6>
                            <h3 class="mb-0 text-info">{{ $completedWorkshops ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Stats --}}
    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Upcoming Workshops</h6>
                            <h4 class="mb-0">{{ $upcomingWorkshops ?? 0 }}</h4>
                        </div>
                        <div class="text-primary">
                            <i class="ri-calendar-line fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Pending Payment Confirmation</h6>
                            <h4 class="mb-0">{{ $pendingRegistrations ?? 0 }}</h4>
                        </div>
                        <div class="text-warning">
                            <i class="ri-time-line fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- Charts Section --}}
    <div class="row mb-4">
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">Workshop Participants</h5>
                    <small class="text-muted">Number of confirmed participants per workshop</small>
                </div>
                <div class="card-body">
                    <div style="height: 400px;">
                        <canvas id="participantChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    {{-- Recent Workshops Table --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">Recent Workshops</h5>
                    <small class="text-muted">Latest workshop activities</small>
                </div>
                <a href="{{ url('data/workshop') }}" class="btn btn-primary btn-sm">
                    <i class="ri-add-line"></i> Manage Workshops
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3">Workshop Title</th>
                            <th class="py-3">Start Date</th>
                            <th class="py-3">End Date</th>
                            <th class="py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentWorkshops as $workshop)
                            <tr>
                                <td class="px-4 py-3">
                                    <h6 class="mb-1">{{ $workshop->title }}</h6>
                                    <small class="text-muted">ID: {{ $workshop->id }}</small>
                                </td>
                                <td class="py-3">
                                    {{ \Carbon\Carbon::parse($workshop->workshop_start_date)->format('M d, Y') }}
                                </td>
                                <td class="py-3">
                                    {{ \Carbon\Carbon::parse($workshop->workshop_end_date)->format('M d, Y') }}
                                </td>x
                                <td class="py-3">
                                    @php $label = workshop_status()[$workshop->status] ?? 'Unknown'; @endphp
                                    <span class="badge 
                                        @switch($workshop->status)
                                            @case(1) bg-success @break
                                            @case(2) bg-primary @break
                                            @case(3) bg-danger @break
                                            @default bg-secondary
                                        @endswitch">
                                        {{ $label }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="ri-folder-open-line fs-3 d-block mb-2"></i>
                                    No workshops found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Check if we have data before creating charts
    const chartLabels = @json($chartData['labels'] ?? []);
    const chartData = @json($chartData['participants'] ?? []);
    
    console.log('Chart Labels:', chartLabels);
    console.log('Chart Data:', chartData);
    
    // Participant Chart
    const participantCtx = document.getElementById('participantChart');
    if (participantCtx) {
        // Check if we have data
        if (chartLabels.length > 0 && chartData.length > 0) {
            new Chart(participantCtx, {
                type: 'bar',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        label: 'Total Participants',
                        data: chartData,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { 
                            display: false 
                        },
                        tooltip: { 
                            enabled: true 
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        },
                        x: {
                            ticks: {
                                maxRotation: 45,
                                minRotation: 0
                            }
                        }
                    }
                }
            });
        } else {
            // Show no data message
            participantCtx.parentElement.innerHTML = '<div class="d-flex align-items-center justify-content-center h-100"><p class="text-muted">No workshop data available</p></div>';
        }
    }
</script>
@endpush