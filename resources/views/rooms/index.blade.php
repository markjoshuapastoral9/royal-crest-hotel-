@extends('layouts.app')
@section('title', __('site.ri_title'))

@push('styles')
<style>
.rooms-page { background: var(--bg-dark, #101111); min-height: 100vh; }
.page-hero-rooms { background: linear-gradient(135deg, var(--bg-dark) 0%, var(--surface) 100%); padding: 100px 0 60px; border-bottom: 1px solid var(--border); }
.filter-card { background: var(--surface, #1a1214); border: 1px solid var(--border); border-radius: 20px; padding: 1.8rem; position: sticky; top: 90px; }
.filter-card h6 { color: #fff; font-size: .75rem; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 1.2rem; font-family: 'Inter', sans-serif; }
.filter-card label { color: var(--text-sec, #C0C0C0); font-size: .8rem; font-weight: 600; }
.filter-card .form-check-label { color: rgba(255,255,255,.75); font-size: .85rem; }
.filter-card .form-check-input:checked { background-color: var(--gold); border-color: var(--gold); }
.filter-card hr { border-color: var(--border); opacity: 1; }
.result-count { color: var(--text-sec); font-size: .85rem; font-family: 'Inter', sans-serif; }
.room-card-dark { background: var(--surface, #1a1214); border: 1px solid var(--border); border-radius: 18px; overflow: hidden; transition: transform .35s, box-shadow .35s, border-color .35s; }
.room-card-dark:hover { transform: translateY(-6px); box-shadow: 0 20px 50px rgba(0,0,0,.5); border-color: rgba(166,130,74,.3); }
.room-card-dark .card-body { background: var(--surface); color: #fff; }
.room-card-dark h6 { color: #fff !important; }
.room-card-dark .text-muted { color: var(--text-sec, #C0C0C0) !important; }
.room-card-dark .badge.bg-light { background: rgba(255,255,255,.07) !important; color: var(--text-sec) !important; border-color: var(--border) !important; }
.no-results { padding: 80px 20px; text-align: center; }
.no-results i { font-size: 4rem; color: rgba(166,130,74,.3); }
.no-results h5 { color: var(--text-sec); margin-top: 1.5rem; }

@media (max-width: 991px) {
    .filter-card { position: static !important; margin-bottom: 1.5rem; border-radius: 14px; }
    .page-hero-rooms { padding: 80px 0 30px; }
    .page-hero-rooms h1 { font-size: 1.7rem; }
    section[style] { padding: 30px 0 !important; }
}
@media (max-width: 576px) {
    .filter-card { padding: 1rem; }
    .room-card-dark .card-body { padding: .8rem !important; }
}
</style>
@endpush

@section('content')
<div class="rooms-page">
<!-- Page Hero -->
<div class="page-hero-rooms">
    <div class="container text-center">
        <span class="section-tag">{{ __('site.ri_accommodations') }}</span>
        <h1 class="mt-2 mb-3" style="color:#fff;">{{ __('site.ri_title') }}</h1>
        <p style="color:var(--text-sec);">{{ __('site.ri_subtitle') }}</p>
    </div>
</div>

<section style="padding:60px 0;">
    <div class="container">
        {{-- Mobile filter toggle --}}
        <div class="d-lg-none mb-3">
            <button class="btn btn-outline-gold w-100" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse">
                <i class="bi bi-funnel me-2"></i>{{ __('site.ri_show_filters') }}
            </button>
        </div>
        <div class="row g-4">
            <!-- Filters -->
            <div class="col-lg-3">
                <div class="collapse d-lg-block" id="filterCollapse">
                    <div class="filter-card">
                    <h6>{{ __('site.ri_filter_rooms') }}</h6>
                    <form action="{{ route('rooms.index') }}" method="GET" id="filterForm">
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">{{ __('site.ri_room_type') }}</label>
                            @foreach($roomTypes as $type)
                            <div class="form-check mb-1">
                                <input class="form-check-input" type="radio" name="type" value="{{ $type->slug }}" id="type_{{ $type->id }}"
                                    {{ request('type') === $type->slug ? 'checked' : '' }} onchange="document.getElementById('filterForm').submit()">
                                <label class="form-check-label" for="type_{{ $type->id }}">{{ $type->name }}</label>
                            </div>
                            @endforeach
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="radio" name="type" value="" id="type_all" {{ !request('type') ? 'checked' : '' }} onchange="document.getElementById('filterForm').submit()">
                                <label class="form-check-label" for="type_all">{{ __('site.ri_all_types') }}</label>
                            </div>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">{{ __('site.ri_price_range') }}</label>
                            <div class="row g-2">
                                <div class="col-6"><input type="number" name="min_price" class="form-control form-control-sm" placeholder="Min ₱" value="{{ request('min_price') }}"></div>
                                <div class="col-6"><input type="number" name="max_price" class="form-control form-control-sm" placeholder="Max ₱" value="{{ request('max_price') }}"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">{{ __('site.ri_guests') }}</label>
                            <select name="capacity" class="form-select form-select-sm">
                                <option value="">{{ __('site.ri_any') }}</option>
                                @for($i=1;$i<=6;$i++)<option value="{{ $i }}" {{ request('capacity')==$i?'selected':'' }}>{{ $i }}+</option>@endfor
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">{{ __('site.ri_check_in') }}</label>
                            <input type="date" name="check_in" class="form-control form-control-sm" value="{{ request('check_in') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">{{ __('site.ri_check_out') }}</label>
                            <input type="date" name="check_out" class="form-control form-control-sm" value="{{ request('check_out') }}">
                        </div>
                        <button type="submit" class="btn btn-gold btn-sm w-100 mb-2">{{ __('site.ri_apply_filters') }}</button>
                        <a href="{{ route('rooms.index') }}" class="btn btn-outline-gold btn-sm w-100">{{ __('site.ri_clear') }}</a>
                    </form>
                    </div>
                </div>
            </div>

            <!-- Room Grid -->
            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <span class="result-count">
                        {{ $rooms->total() }} {{ $rooms->total() != 1 ? __('site.ri_rooms_found') : __('site.ri_room_found') }}
                    </span>
                </div>
                @if($rooms->count())
                <div class="row g-4">
                    @foreach($rooms as $room)
                    <div class="col-md-6 col-xl-4">
                        <div class="room-card-dark card h-100">
                            <div class="position-relative overflow-hidden" style="height:200px;">
                                <img src="{{ $room->thumbnail_url }}" class="w-100 h-100" style="object-fit:cover;transition:transform .4s;" alt="{{ $room->translated_name }}"
                                     onmouseover="this.style.transform='scale(1.06)'" onmouseout="this.style.transform='scale(1)'">
                            </div>
                            <div class="card-body p-3 d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start mb-1">
                                    <h6 class="fw-bold mb-0">{{ $room->translated_name }}</h6>
                                    <span class="price" style="font-size:1.05rem;">{{ $room->formatted_price }}</span>
                                </div>
                                <small class="text-muted mb-2">{{ __('site.ri_accommodations') }} {{ $room->room_number }} · {{ __('site.ri_floor') }} {{ $room->floor }}</small>
                                <div class="d-flex flex-wrap gap-1 mb-3">
                                    <span class="badge bg-light text-dark border" style="font-size:.7rem;"><i class="bi bi-people me-1"></i>{{ $room->capacity }}</span>
                                    <span class="badge bg-light text-dark border" style="font-size:.7rem;"><i class="bi bi-moon me-1"></i>{{ $room->beds }} {{ $room->beds > 1 ? __('site.rooms_beds') : __('site.rooms_bed') }}</span>
                                    @if($room->has_wifi)<span class="badge bg-light text-dark border" style="font-size:.7rem;"><i class="bi bi-wifi"></i> WiFi</span>@endif
                                    @if($room->has_aircon)<span class="badge bg-light text-dark border" style="font-size:.7rem;"><i class="bi bi-wind"></i> A/C</span>@endif
                                </div>
                                @php $avail = $room->available_units ?? $room->total_units ?? 5; @endphp
                                <div class="mb-2">
                                    @if($avail > 1)
                                        <span class="badge" style="background:rgba(74,222,128,.15);color:#4ade80;font-size:.7rem;border:1px solid rgba(74,222,128,.3);">
                                            <i class="bi bi-door-open me-1"></i>{{ $avail }} unit{{ $avail > 1 ? 's' : '' }} available
                                        </span>
                                    @elseif($avail === 1)
                                        <span class="badge" style="background:rgba(250,204,21,.12);color:#facc15;font-size:.7rem;border:1px solid rgba(250,204,21,.3);">
                                            <i class="bi bi-exclamation-circle me-1"></i>Only 1 unit left!
                                        </span>
                                    @else
                                        <span class="badge" style="background:rgba(220,38,38,.12);color:#f87171;font-size:.7rem;border:1px solid rgba(220,38,38,.3);">
                                            <i class="bi bi-x-circle me-1"></i>Fully booked for these dates
                                        </span>
                                    @endif
                                </div>


                                <div class="mt-auto d-flex gap-2">
                                    <a href="{{ route('rooms.show', $room) }}" class="btn btn-outline-gold btn-sm flex-fill" style="font-size:.8rem;">{{ __('site.ri_details') }}</a>
                                    @auth
                                        <a href="{{ route('booking.create', $room->id) }}{{ request('check_in') ? '?check_in='.request('check_in').'&check_out='.request('check_out') : '' }}" class="btn btn-gold btn-sm flex-fill" style="font-size:.8rem;">{{ __('site.ri_book') }}</a>
                                    @else
                                        <a href="{{ route('login') }}?redirect={{ urlencode(route('booking.create', $room->id)) }}" class="btn btn-gold btn-sm flex-fill" style="font-size:.8rem;">{{ __('site.ri_book') }}</a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="mt-4">{{ $rooms->links() }}</div>
                @else
                <div class="no-results">
                    <i class="bi bi-door-open"></i>
                    <h5>{{ __('site.ri_no_match') }}</h5>
                    <a href="{{ route('rooms.index') }}" class="btn btn-gold mt-3">{{ __('site.ri_view_all') }}</a>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
</div>
@endsection

@push('styles')
<style>
.btn-xs {
    font-size: 0.6rem;
    padding: 2px 8px;
    line-height: 1.2;
}

.room-unit-card {
    transition: all 0.2s ease;
    cursor: pointer;
}

.room-unit-card:hover {
    background: rgba(166,130,74,.1) !important;
    transform: translateY(-1px);
}

.collapse.show .room-unit-card {
    animation: fadeInUp 0.3s ease;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
@endpush
