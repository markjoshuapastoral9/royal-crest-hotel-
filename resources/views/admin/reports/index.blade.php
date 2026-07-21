@extends('layouts.admin')
@section('title', 'Reports')
@section('breadcrumb')<li class="breadcrumb-item active">Reports</li>@endsection
@push('styles')<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Reports & Analytics</h4>
    <a href="{{ route('admin.reports.export-pdf', request()->query()) }}" class="btn btn-outline-secondary btn-sm" target="_blank">
        <i class="bi bi-file-pdf me-1"></i>Export PDF
    </a>
</div>

<!-- Date Filter -->
<div class="admin-card p-3 mb-4">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-3">
            <label class="form-label small fw-semibold">From Date</label>
            <input type="date" name="date_from" class="form-control form-control-sm" value="{{ $dateFrom }}">
        </div>
        <div class="col-md-3">
            <label class="form-label small fw-semibold">To Date</label>
            <input type="date" name="date_to" class="form-control form-control-sm" value="{{ $dateTo }}">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-gold btn-sm w-100">Generate Report</button>
        </div>
    </form>
</div>

<!-- Summary Cards -->
<div class="row g-4 mb-4">
    @foreach([
        ['Total Bookings','bi-calendar2','bg-primary text-white',$stats['total_bookings']],
        ['Confirmed','bi-check-circle','bg-success text-white',$stats['confirmed']],
        ['Cancelled','bi-x-circle','bg-danger text-white',$stats['cancelled']],
        ['Completed','bi-trophy','bg-info text-white',$stats['completed']],
    ] as [$l,$i,$bg,$v])
    <div class="col-6 col-md-3">
        <div class="stat-card card {{ $bg }} border-0">
            <div class="card-body text-center">
                <i class="bi {{ $i }} fs-2 mb-1 d-block"></i>
                <div class="fw-bold fs-3">{{ $v }}</div>
                <div class="small opacity-75">{{ $l }}</div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="admin-card p-4 text-center" style="background:linear-gradient(135deg,#1a1a1a,#2c1f0a);">
            <div class="text-white-50 small mb-1">Total Revenue</div>
            <div class="text-gold fw-bold" style="font-size:2rem;">₱{{ number_format($stats['total_revenue'],2) }}</div>
            <div class="text-white-50 small">{{ $dateFrom }} – {{ $dateTo }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="admin-card p-4 text-center">
            <div class="text-muted small mb-1">Avg. Booking Value</div>
            <div class="fw-bold text-gold" style="font-size:2rem;">₱{{ number_format($stats['avg_booking_value'],2) }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="admin-card p-4">
            <canvas id="monthChart" height="120"></canvas>
        </div>
    </div>
</div>

<!-- Popular Rooms -->
<div class="admin-card p-4 mb-4">
    <h6 class="fw-bold mb-3">Most Popular Rooms</h6>
    <div class="table-responsive">
        <table class="table table-sm mb-0">
            <thead><tr><th>Room</th><th>Bookings</th><th>Revenue</th></tr></thead>
            <tbody>
                @forelse($popularRooms as $pr)
                <tr>
                    <td class="small fw-semibold">{{ $pr->room->name ?? 'N/A' }}</td>
                    <td class="small">{{ $pr->bookings_count }}</td>
                    <td class="small fw-semibold text-gold">₱{{ number_format($pr->revenue,2) }}</td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-center text-muted py-3">No data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Bookings Table -->
<div class="admin-card p-4">
    <h6 class="fw-bold mb-3">Bookings in Period ({{ $bookings->count() }} records)</h6>
    <div class="table-responsive">
        <table class="table table-sm mb-0">
            <thead><tr><th>Booking #</th><th>Guest</th><th>Room</th><th>Check-in</th><th>Amount</th><th>Status</th></tr></thead>
            <tbody>
                @forelse($bookings as $b)
                <tr>
                    <td class="small text-gold">{{ $b->booking_number }}</td>
                    <td class="small">{{ $b->guest_name }}</td>
                    <td class="small">{{ $b->room->name }}</td>
                    <td class="small">{{ $b->check_in->format('M d, Y') }}</td>
                    <td class="small fw-semibold">₱{{ number_format($b->total_amount,2) }}</td>
                    <td><span class="badge bg-{{ $b->status_badge }}" style="font-size:.7rem;">{{ ucfirst(str_replace('_',' ',$b->status)) }}</span></td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-3">No bookings in this period.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
const rev = @json($monthlyRevenue);
const labels = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
const data = labels.map((_,i) => parseFloat(rev[i+1] || 0));
new Chart(document.getElementById('monthChart'), {
    type: 'line',
    data: { labels, datasets: [{ data, borderColor: '#C9A84C', backgroundColor: 'rgba(201,168,76,0.1)', tension: 0.4, fill: true, pointRadius: 3 }] },
    options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { callback: v => '₱' + (v/1000).toFixed(0) + 'k' } } } }
});
</script>
@endpush
