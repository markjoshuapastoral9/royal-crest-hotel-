@extends('layouts.app')
@section('title', 'My Dashboard')

@push('styles')
<style>
.dash-page { background: #101111; min-height: 100vh; }
.dash-hero { background: linear-gradient(135deg, #1e1613 0%, #241a0e 50%, #1e1613 100%); padding: 80px 0 50px; border-bottom: 1px solid rgba(166,130,74,.25); }
.dash-hero h1 { color: #E6E2DA; font-family: 'Playfair Display', serif; font-size: 2rem; }
.dash-hero p { color: #B8AFA6; }

.stat-card { background: #231d1e; border: 1px solid rgba(166,130,74,.22); border-radius: 18px; padding: 1.8rem 1.5rem; text-align: center; transition: all .3s; }
.stat-card:hover { border-color: rgba(166,130,74,.5); transform: translateY(-4px); box-shadow: 0 10px 30px rgba(0,0,0,.5); }
.stat-icon { width: 56px; height: 56px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 1rem; font-size: 1.5rem; }
.stat-icon.primary { background: rgba(166,130,74,.18); color: #C9A87C; }
.stat-icon.warning { background: rgba(212,168,83,.15); color: #D4A853; }
.stat-icon.success { background: rgba(74,222,128,.1); color: #4ade80; }
.stat-icon.info    { background: rgba(166,130,74,.12); color: #A6824A; }
.stat-value { font-size: 2.2rem; font-weight: 700; color: #E6E2DA; font-family: 'Playfair Display', serif; line-height: 1; }
.stat-label { color: #9a9189; font-size: .8rem; margin-top: .4rem; font-family: 'Inter', sans-serif; letter-spacing: .5px; }

.content-card { background: #231d1e; border: 1px solid rgba(166,130,74,.22); border-radius: 18px; padding: 2rem; }
.content-card h5 { color: #E6E2DA; font-size: 1.1rem; font-weight: 700; font-family: 'Inter', sans-serif; }

.booking-item { background: rgba(255,255,255,.04); border: 1px solid rgba(166,130,74,.12); border-radius: 12px; padding: 1rem; margin-bottom: .8rem; display: flex; align-items: center; gap: 1rem; transition: all .3s; }
.booking-item:hover { background: rgba(166,130,74,.07); border-color: rgba(166,130,74,.3); }
.booking-img { width: 64px; height: 64px; border-radius: 10px; object-fit: cover; flex-shrink: 0; }
.booking-info { flex: 1; }
.booking-title { color: #E6E2DA; font-size: .9rem; font-weight: 600; margin-bottom: .2rem; }
.booking-meta { color: #9a9189; font-size: .75rem; }
.booking-price { color: #C9A87C; font-weight: 700; font-size: .95rem; }

.profile-card { background: #231d1e; border: 1px solid rgba(166,130,74,.22); border-radius: 18px; padding: 2rem; text-align: center; }
.profile-avatar { width: 90px; height: 90px; border-radius: 50%; object-fit: cover; margin-bottom: 1.2rem; border: 3px solid rgba(166,130,74,.4); }
.profile-name { color: #E6E2DA; font-size: 1.2rem; font-weight: 700; margin-bottom: .3rem; font-family: 'Inter', sans-serif; }
.profile-email { color: #9a9189; font-size: .85rem; margin-bottom: .5rem; }

.quick-links { background: #231d1e; border: 1px solid rgba(166,130,74,.22); border-radius: 18px; padding: 1.8rem; margin-top: 1.5rem; }
.quick-links h6 { color: #C9A87C; font-size: .72rem; font-weight: 700; margin-bottom: 1.2rem; font-family: 'Inter', sans-serif; letter-spacing: 2.5px; text-transform: uppercase; }
.quick-link { display: flex; align-items: center; gap: 12px; padding: .75rem 0; border-bottom: 1px solid rgba(255,255,255,.06); color: #B8AFA6; text-decoration: none; font-size: .88rem; transition: all .25s; }
.quick-link:last-child { border-bottom: none; }
.quick-link:hover { color: #E6E2DA; padding-left: 8px; }
.quick-link i { color: #A6824A; font-size: 1.05rem; width: 20px; text-align: center; }

.empty-state { text-align: center; padding: 3rem 1rem; color: #9a9189; }
.empty-state i { font-size: 3rem; color: rgba(166,130,74,.35); margin-bottom: 1rem; display: block; }

@media (max-width: 768px) {
    .dash-hero { padding: 70px 0 25px; }
    .dash-hero h1 { font-size: 1.5rem; }
    .stat-card { padding: 1.2rem 1rem; border-radius: 14px; }
    .stat-value { font-size: 1.8rem; }
    .stat-icon { width: 44px; height: 44px; font-size: 1.2rem; margin-bottom: .7rem; }
    .content-card { padding: 1.2rem; border-radius: 14px; }
    .booking-item { flex-wrap: wrap; gap: .6rem; }
    .booking-img { width: 52px; height: 52px; border-radius: 8px; }
    .profile-card { padding: 1.4rem; border-radius: 14px; }
    .quick-links { padding: 1.2rem; border-radius: 14px; margin-top: 1rem; }
    section[style] { padding: 30px 0 !important; }
}
</style>
@endpush

@section('content')
<div class="dash-page">
<div class="dash-hero">
    <div class="container">
        <h1>{{ __('site.cd_welcome') }} {{ auth()->user()->name }}</h1>
        <p>{{ __('site.cd_manage') }}</p>
    </div>
</div>

<section style="padding:50px 0;">
<div class="container">
    <!-- Stats -->
    <div class="row g-4 mb-5">
        <!-- LAB EXAM: System-wide Total Bookings -->
        <div class="col-6 col-md-3">
            <div class="stat-card h-100">
                <div class="stat-icon primary"><i class="bi bi-calendar-check-fill"></i></div>
                <div class="stat-value">{{ $totalBookings }}</div>
                <div class="stat-label">{{ __('Total Bookings') }}</div>
            </div>
        </div>

        <!-- LAB EXAM: System-wide Total Users -->
        <div class="col-6 col-md-3">
            <div class="stat-card h-100">
                <div class="stat-icon success"><i class="bi bi-people-fill"></i></div>
                <div class="stat-value">{{ $totalUsers }}</div>
                <div class="stat-label">{{ __('Registered Users') }}</div>
            </div>
        </div>

        <!-- User's Personal Stats -->
        @foreach([[__('site.cd_stat_pending'),'bi-hourglass-split','warning',$stats['pending']],[__('site.cd_stat_confirmed'),'bi-check-circle','info',$stats['confirmed']]] as [$label,$icon,$color,$val])
        <div class="col-6 col-md-3">
            <div class="stat-card h-100">
                <div class="stat-icon {{ $color }}"><i class="bi {{ $icon }}"></i></div>
                <div class="stat-value">{{ $val }}</div>
                <div class="stat-label">{{ $label }}</div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="row g-4">
        <!-- Bookings -->
        <div class="col-lg-8">
            <div class="content-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">{{ __('site.cd_recent_bookings') }}</h5>
                    <a href="{{ route('customer.bookings') }}" class="btn btn-outline-gold btn-sm">{{ __('site.cd_view_all') }}</a>
                </div>
                @forelse($bookings as $b)
                <div class="booking-item">
                    <img src="{{ $b->room->thumbnail_url }}" class="booking-img" alt="{{ $b->room->translated_name }}">
                    <div class="booking-info">
                        <div class="booking-title">{{ $b->room->translated_name }}</div>
                        <div class="booking-meta">Room {{ $b->room->room_number }} • {{ $b->booking_number }}</div>
                        <div class="booking-meta"><i class="bi bi-calendar me-1"></i>{{ $b->check_in->format('M d') }} – {{ $b->check_out->format('M d, Y') }}</div>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-{{ $b->status_badge }} mb-1" style="font-size:.7rem;">{{ ucfirst(str_replace('_',' ',$b->status)) }}</span>
                        <div class="booking-price">₱{{ number_format($b->total_amount,2) }}</div>
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <i class="bi bi-calendar-x d-block"></i>
                    <div style="margin-bottom:1rem;">{{ __('site.cd_no_bookings') }}</div>
                    <a href="{{ route('rooms.index') }}" class="btn btn-gold btn-sm">{{ __('site.cd_book_room') }}</a>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Profile Quick View -->
        <div class="col-lg-4">
            <div class="profile-card">
                <img src="{{ auth()->user()->avatar_url }}" class="profile-avatar" alt="{{ auth()->user()->name }}">
                <div class="profile-name">{{ auth()->user()->name }}</div>
                <div class="profile-email">{{ auth()->user()->email }}</div>
                @if(auth()->user()->phone)<div class="profile-email" style="margin-top:-.8rem;">{{ auth()->user()->phone }}</div>@endif
                <a href="{{ route('customer.profile') }}" class="btn btn-outline-gold btn-sm w-100 mb-2">{{ __('site.cd_edit_profile') }}</a>
                <a href="{{ route('rooms.index') }}" class="btn btn-gold btn-sm w-100">{{ __('site.cd_book_room') }}</a>
            </div>

            <div class="quick-links">
                <h6>{{ __('site.cd_quick_links') }}</h6>
                <a href="{{ route('customer.dashboard') }}" class="quick-link"><i class="bi bi-speedometer2"></i>{{ __('Dashboard') }}</a>
                <a href="{{ route('rooms.index') }}" class="quick-link"><i class="bi bi-door-open"></i>{{ __('site.cd_browse_rooms') }}</a>
                <a href="{{ route('customer.bookings') }}" class="quick-link"><i class="bi bi-calendar-check"></i>{{ __('site.cd_all_bookings') }}</a>
                <a href="{{ route('customer.calendar') }}" class="quick-link"><i class="bi bi-calendar3"></i>Booking Calendar</a>
                <a href="{{ route('contact') }}" class="quick-link"><i class="bi bi-headset"></i>{{ __('site.cd_contact_support') }}</a>
            </div>
        </div>
    </div>
</div>
</section>
</div>
@endsection
