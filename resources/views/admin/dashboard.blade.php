@extends('layouts.admin')
@section('title', 'Dashboard')
@section('breadcrumb')
<li class="breadcrumb-item active">Dashboard</li>
@endsection

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
@endpush

@section('content')
<!-- Stat Cards -->
<div class="row g-4 mb-4">
    @foreach([
        ['Today\'s Bookings','bi-calendar-plus','bg-primary','text-white',$stats['today_bookings'],'New today'],
        ['Available Rooms','bi-door-open','bg-success','text-white',$stats['available_rooms'],'Ready'],
        ['Occupied Rooms','bi-people-fill','bg-warning','text-dark',$stats['occupied_rooms'],'In use'],
        ['Pending Reviews','bi-hourglass-split','bg-danger','text-white',$stats['pending_reservations'],'Need action'],
        ['Monthly Revenue','bi-currency-exchange','','','₱'.number_format($stats['monthly_revenue'],0),'This month'],
        ['Total Guests','bi-person-lines-fill','','','',number_format($stats['total_guests']).' registered'],
    ] as $i => [$label,$icon,$bg,$fg,$val,$sub])
    @if($i < 4)
    <div class="col-6 col-md-3">
        <div class="stat-card card {{ $bg }} border-0">
            <div class="card-body {{ $fg }}">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="small fw-semibold opacity-75 mb-1">{{ $label }}</div>
                        <div class="fw-bold fs-2">{{ $val }}</div>
                        <div class="small opacity-60">{{ $sub }}</div>
                    </div>
                    <div class="stat-icon {{ str_replace(['bg-','text-'],['bg-opacity-25 bg-',''] ,$bg . ' ' . $fg) }}" style="background:rgba(255,255,255,.2)!important;">
                        <i class="bi {{ $icon }} {{ $fg }}"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endforeach

    <div class="col-md-3 col-6">
        <div class="stat-card card border-0" style="background:linear-gradient(135deg,#2c1f0a,#1a1a1a);">
            <div class="card-body text-white">
                <div class="small fw-semibold opacity-75 mb-1">Monthly Revenue</div>
                <div class="fw-bold fs-4 text-gold">₱{{ number_format($stats['monthly_revenue'],0) }}</div>
                <div class="small opacity-60">This month</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card card border-0" style="background:var(--admin-surface);border:1px solid var(--admin-border)!important;">
            <div class="card-body">
                <div class="small fw-semibold mb-1" style="color:#B8AFA6;">Total Guests</div>
                <div class="fw-bold fs-4" style="color:#E6E2DA;">{{ number_format($stats['total_guests']) }}</div>
                <div class="small" style="color:#B8AFA6;">Registered users</div>
            </div>
        </div>
    </div>

    <!-- Room occupancy quick stats -->
    <div class="col-md-3 col-6">
        <div class="stat-card card border-0" style="background:var(--admin-surface);border:1px solid var(--admin-border)!important;">
            <div class="card-body">
                <div class="small fw-semibold mb-1" style="color:#B8AFA6;">Confirmed Today</div>
                <div class="fw-bold fs-4" style="color:#E6E2DA;">{{ $stats['confirmed_today'] }}</div>
                <div class="small" style="color:#B8AFA6;">Bookings confirmed</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card card border-0" style="background:var(--admin-surface);border:1px solid var(--admin-border)!important;">
            <div class="card-body">
                <div class="small fw-semibold mb-1" style="color:#B8AFA6;">Cancelled / Month</div>
                <div class="fw-bold fs-4 text-danger">{{ $stats['cancelled_this_month'] }}</div>
                <div class="small" style="color:#B8AFA6;">This month</div>
            </div>
        </div>
    </div>
</div>

<!-- Charts -->
<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="admin-card p-4">
            <h6 class="fw-bold mb-3">Monthly Revenue ({{ date('Y') }})</h6>
            <canvas id="revenueChart" height="80"></canvas>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="admin-card p-4 h-100">
            <h6 class="fw-bold mb-3">Room Status</h6>
            <canvas id="occupancyChart"></canvas>
            <div class="mt-3 small">
                @foreach(['available'=>['success','Available'],'occupied'=>['warning','Occupied'],'reserved'=>['info','Reserved'],'maintenance'=>['secondary','Maintenance']] as $s=>[$c,$l])
                <div class="d-flex justify-content-between mb-1">
                    <span><span class="badge bg-{{ $c }} me-1"></span>{{ $l }}</span>
                    <span class="fw-semibold">{{ $roomStats[$s] ?? 0 }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Recent Bookings Table -->
<div class="admin-card p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold mb-0">Recent Bookings</h6>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-outline-secondary">View All</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Booking #</th>
                    <th>Guest</th>
                    <th>Room</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentBookings as $b)
                <tr>
                    <td><span class="fw-semibold text-gold small" style="letter-spacing:1px;">{{ $b->booking_number }}</span></td>
                    <td>
                        <div class="small fw-semibold">{{ $b->guest_name }}</div>
                        <div class="small text-muted">{{ $b->guest_email }}</div>
                    </td>
                    <td class="small">{{ $b->room->name }}</td>
                    <td class="small">{{ $b->check_in->format('M d, Y') }}</td>
                    <td class="small">{{ $b->check_out->format('M d, Y') }}</td>
                    <td class="fw-semibold small">₱{{ number_format($b->total_amount, 2) }}</td>
                    <td><span class="badge bg-{{ $b->status_badge }}">{{ ucfirst(str_replace('_',' ',$b->status)) }}</span></td>
                    <td><a href="{{ route('admin.bookings.show', $b) }}" class="btn btn-sm btn-outline-secondary">View</a></td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted py-3">No bookings found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Revenue Chart
const revenueData = @json($revenueChart);
const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
const revenueByMonth = Array(12).fill(0);
revenueData.forEach(r => { revenueByMonth[r.month - 1] = parseFloat(r.revenue); });

new Chart(document.getElementById('revenueChart'), {
    type: 'bar',
    data: {
        labels: months,
        datasets: [{
            label: 'Revenue (₱)',
            data: revenueByMonth,
            backgroundColor: 'rgba(201,168,76,0.7)',
            borderColor: '#C9A84C',
            borderWidth: 1,
            borderRadius: 6,
        }]
    },
    options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { callback: v => '₱' + v.toLocaleString() } } } }
});

// Occupancy Doughnut
const occ = @json($roomStats);
new Chart(document.getElementById('occupancyChart'), {
    type: 'doughnut',
    data: {
        labels: ['Available','Occupied','Reserved','Maintenance'],
        datasets: [{
            data: [occ.available||0, occ.occupied||0, occ.reserved||0, occ.maintenance||0],
            backgroundColor: ['#198754','#ffc107','#0dcaf0','#6c757d'],
            borderWidth: 0,
        }]
    },
    options: { responsive: true, cutout: '65%', plugins: { legend: { display: false } } }
});
</script>
@endpush
