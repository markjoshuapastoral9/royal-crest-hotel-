@extends('layouts.app')
@section('title', 'Monarch Hotel - Luxury in Calasiao, Pangasinan')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
:root {
    --gold:       #A6824A;
    --gold-light: #C9A87C;
    --gold-dark:  #7A5E32;
    --bg-dark:    #101111;
    --surface:    #1a1214;
    --surface-2:  #150e10;
    --text-pri:   #E6E2DA;
    --text-sec:   #B8AFA6;
    --border:     rgba(230,226,218,0.10);
    --emerald:    #154230;
    --burgundy:   #5D1E21;
}

body { background: var(--bg-dark); color: var(--text-pri); }
h1,h2,h3,h4,h5 { font-family: 'Cormorant Garamond', 'Playfair Display', serif; }

/* ─── HERO ─── */
.hero {
    position: relative;
    min-height: 100vh;
    display: flex;
    align-items: center;
    overflow: hidden;
}
.hero-bg {
    position: absolute;
    inset: 0;
    background: url('{{ asset('images/hero-background.jpg') }}') center/cover no-repeat;
}
.hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to right, rgba(15,15,18,.82) 45%, rgba(15,15,18,.42) 100%);
}
.hero-content { position: relative; z-index: 2; }
.hero-tag {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: .7rem;
    font-weight: 700;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: var(--gold);
    background: rgba(166,130,74,.12);
    border: 1px solid rgba(166,130,74,.3);
    padding: 7px 18px;
    border-radius: 40px;
    margin-bottom: 1.6rem;
}
.hero-title {
    font-size: clamp(3rem, 6.5vw, 5.5rem);
    color: #fff;
    line-height: 1.08;
    font-weight: 700;
    letter-spacing: -.5px;
}
.hero-title em { color: var(--gold); font-style: normal; }
.hero-sub {
    color: var(--text-sec);
    font-family: 'Inter', sans-serif;
    font-size: 1.05rem;
    line-height: 1.85;
    max-width: 480px;
}

/* ─── BUTTONS ─── */
.btn-gold {
    background: var(--gold);
    color: #101111 !important;
    border: 2px solid var(--gold);
    font-weight: 700;
    letter-spacing: .5px;
    transition: all .3s;
    font-family: 'Inter', sans-serif;
}
.btn-gold:hover {
    background: var(--gold-light);
    border-color: var(--gold-light);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(166,130,74,.4);
}
.btn-outline-gold {
    background: transparent;
    color: var(--gold) !important;
    border: 2px solid var(--gold);
    font-weight: 600;
    transition: all .3s;
    font-family: 'Inter', sans-serif;
}
.btn-outline-gold:hover {
    background: var(--gold);
    color: #101111 !important;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(166,130,74,.35);
}

/* ─── SECTION COMMON ─── */
.sec-tag {
    display: block;
    font-size: .68rem;
    font-weight: 700;
    letter-spacing: 3.5px;
    text-transform: uppercase;
    color: var(--gold);
    margin-bottom: .75rem;
    font-family: 'Inter', sans-serif;
}
.sec-title {
    font-size: clamp(2rem, 3.5vw, 2.9rem);
    font-weight: 700;
    line-height: 1.15;
    color: #fff;
}
.sec-title.dark { color: var(--bg-dark); }
.gold-line {
    width: 48px;
    height: 3px;
    background: linear-gradient(to right, var(--gold), var(--gold-light));
    border-radius: 2px;
    margin: 1rem auto 1.5rem;
}
.gold-line.left { margin-left: 0; }

/* ─── ROOM CARDS ─── */
.room-card-dark {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 20px;
    overflow: hidden;
    transition: transform .35s, box-shadow .35s, border-color .35s;
}
.room-card-dark:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 50px rgba(0,0,0,.5);
    border-color: rgba(166,130,74,.3);
}
.room-card-dark .room-img-wrap {
    position: relative;
    height: 230px;
    overflow: hidden;
}
.room-card-dark .room-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .5s ease;
}
.room-card-dark:hover .room-img-wrap img { transform: scale(1.07); }
.room-card-dark .room-body { padding: 1.4rem 1.6rem 1.6rem; }
.room-price { font-family: 'Cormorant Garamond', serif; color: var(--gold); font-size: 1.5rem; font-weight: 700; }
.room-badge { background: var(--gold); color: #101111; font-size: .65rem; font-weight: 800; letter-spacing: .8px; text-transform: uppercase; padding: 4px 10px; border-radius: 6px; }
.room-meta span { font-size: .78rem; color: var(--text-sec); background: rgba(255,255,255,.06); border: 1px solid var(--border); padding: 3px 10px; border-radius: 20px; }

/* ─── FACILITY CARDS ─── */
.fac-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 20px;
    padding: 2rem 1.6rem;
    text-align: center;
    transition: all .35s;
}
.fac-card:hover { border-color: rgba(166,130,74,.35); transform: translateY(-5px); box-shadow: 0 12px 35px rgba(0,0,0,.35); }
.fac-icon {
    width: 66px;
    height: 66px;
    border-radius: 50%;
    background: linear-gradient(135deg, rgba(166,130,74,.2), rgba(166,130,74,.05));
    border: 1px solid rgba(166,130,74,.25);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.1rem;
    color: var(--gold);
    font-size: 1.6rem;
    transition: all .3s;
}
.fac-card:hover .fac-icon { background: linear-gradient(135deg, var(--gold), var(--gold-dark)); color: #101111; }

/* ─── PROMO CARDS ─── */
.promo-card-dark {
    background: linear-gradient(135deg, #252000 0%, #332400 100%);
    border: 1px solid rgba(166,130,74,.2);
    border-radius: 20px;
    padding: 2rem;
    position: relative;
    overflow: hidden;
    transition: all .35s;
}
.promo-card-dark::before {
    content: '';
    position: absolute;
    top: -40px; right: -40px;
    width: 160px; height: 160px;
    background: radial-gradient(circle, rgba(166,130,74,.18) 0%, transparent 70%);
    border-radius: 50%;
}
.promo-card-dark:hover { border-color: rgba(166,130,74,.5); box-shadow: 0 12px 40px rgba(166,130,74,.12); }

/* ─── TESTIMONIAL CARDS ─── */
.testi-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 20px;
    padding: 2rem;
    position: relative;
    overflow: hidden;
    transition: all .35s;
    height: 100%;
}
.testi-card:hover { border-color: rgba(166,130,74,.25); box-shadow: 0 12px 35px rgba(0,0,0,.35); }
.testi-card::before { content: '\201C'; font-size: 9rem; color: var(--gold); opacity: .07; position: absolute; top: -25px; left: 8px; font-family: Georgia,serif; line-height: 1; }
.star-g { color: var(--gold); font-size: .82rem; }

/* ─── ABOUT SECTION ─── */
.about-wrap { background: var(--surface-2); }
.about-img-stack { position: relative; }
.about-img-stack .img-main { border-radius: 20px; width: 100%; height: 420px; object-fit: cover; }
.about-img-stack .img-badge {
    position: absolute;
    bottom: -20px; left: -20px;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 1.2rem 1.6rem;
    text-align: center;
    box-shadow: 0 12px 40px rgba(0,0,0,.4);
}

/* ─── CTA ─── */
.cta-wrap {
    background: linear-gradient(135deg, #101111 0%, #1a120a 50%, #101111 100%);
    border-top: 1px solid var(--border);
    border-bottom: 1px solid var(--border);
}

/* ─── STATS BAR ─── */
.stats-bar { background: var(--surface); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); }
.stat-item { padding: 1.6rem 0; text-align: center; }
.stat-num { font-family: 'Cormorant Garamond', serif; font-size: 2.4rem; color: var(--gold); font-weight: 700; line-height: 1; }
.stat-label { font-size: .75rem; color: var(--text-sec); letter-spacing: 1.5px; text-transform: uppercase; margin-top: .25rem; font-family: 'Inter', sans-serif; }

/* ─── FADE UP ─── */
.fade-up { opacity: 0; transform: translateY(28px); transition: opacity .65s ease, transform .65s ease; }
.fade-up.visible { opacity: 1; transform: translateY(0); }

/* ─── MOBILE ─── */
@media (max-width: 991px) {
    .hero { min-height: 100svh; }
    .hero-title { font-size: clamp(2.2rem, 7vw, 3.5rem); }
    .hero-sub { font-size: .95rem; }
}

@media (max-width: 768px) {
    .hero-title { font-size: 2rem; }
    .hero-sub { font-size: .9rem; }
    .stat-num { font-size: 1.9rem; }
    .stat-label { font-size: .68rem; }
    .about-img-stack .img-main { height: 260px; }
    .about-img-badge { position: static !important; margin-top: 1rem; display: inline-block; }
    .room-card-dark .room-img-wrap { height: 190px; }
    .fac-card { padding: 1.4rem 1rem; }
    .promo-card-dark { padding: 1.4rem; }
    .testi-card { padding: 1.4rem; }
    section[style*="padding:90px"] { padding: 50px 0 !important; }
    .cta-wrap { padding: 60px 0 !important; }
}

@media (max-width: 480px) {
    .hero-title { font-size: 1.75rem; }
    .sec-title { font-size: 1.65rem; }
}
</style>
@endpush

@section('content')

{{-- ═══════════════════════════════════════ HERO ═══════════════════════════════════════ --}}
<section class="hero">
    <div class="hero-bg"></div>
    <div class="hero-overlay"></div>
    <div class="container hero-content py-5">
        <div class="row align-items-center g-5">
            {{-- Left: headline --}}
            <div class="col-lg-8 col-xl-7">
                <h1 class="hero-title mb-4">
    {{ __('site.hero_title_line1') }}<br><em>{{ __('site.hero_title_line2') }}</em><br>{{ __('site.hero_title_line3') }}
</h1>
                <p class="hero-sub mb-5">
    {{ __('site.hero_sub') }}
</p>    
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('rooms.index') }}" class="btn btn-gold btn-lg px-4 py-3 rounded-3">
                        <i class="bi bi-rocket-takeoff me-2"></i>{{ __('site.hero_get_started') }}
                    </a>
                    <a href="#featured-rooms" class="btn btn-outline-gold btn-lg px-4 py-3 rounded-3">
                        <i class="bi bi-eye me-2"></i>{{ __('site.hero_explore') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════ STATS BAR ═══════════════════════════════════════ --}}
<div class="stats-bar">
    <div class="container">
        <div class="row g-0 text-center" style="border-left:1px solid var(--border);">
            @foreach([['20+',__('site.stat_room_types')],['8',__('site.stat_facilities')],['5★',__('site.stat_star_rated')],['25+',__('site.stat_years')]] as [$n,$l])
            <div class="col-6 col-md-3 stat-item" style="border-right:1px solid var(--border);">
                <div class="stat-num">{{ $n }}</div>
                <div class="stat-label">{{ $l }}</div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════ ABOUT ═══════════════════════════════════════ --}}
<section class="about-wrap py-5" style="padding:90px 0!important;">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-5 fade-up">
                <div class="about-img-stack">
                    <img src="{{ asset('images/honeymoon-suite.jpg') }}"
                         alt="Monarch Hotel Honeymoon Suite" class="about-img-main"
                         style="border-radius:20px;width:100%;height:420px;object-fit:cover;">
                    <div class="about-img-badge" style="position:absolute;bottom:-20px;left:-18px;background:var(--surface);border:1px solid var(--border);border-radius:16px;padding:1.2rem 1.6rem;text-align:center;box-shadow:0 12px 40px rgba(0,0,0,.5);">
                        <div style="font-family:'Cormorant Garamond',serif;font-size:2.4rem;color:var(--gold);font-weight:700;line-height:1;">25+</div>
                        <div style="font-size:.72rem;color:var(--text-sec);letter-spacing:1.5px;text-transform:uppercase;font-family:'Inter',sans-serif;">{{ __('site.about_years') }}</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 fade-up">
                <span class="sec-tag">{{ __('site.about_tag') }}</span>
                <h2 class="sec-title mb-0">{{ __('site.about_title') }}</h2>
                <div class="gold-line left"></div>
                <p style="color:var(--text-sec);line-height:1.95;margin-bottom:1.2rem;font-family:'Inter',sans-serif;">
                    {{ __('site.about_body1') }}
                </p>
                <p style="color:var(--text-sec);line-height:1.95;margin-bottom:2rem;font-family:'Inter',sans-serif;">
                    {{ __('site.about_body2') }}
                </p>
                <div class="row g-3 mb-4">
                    @foreach([['bi-trophy-fill','about_award'],['bi-star-fill','about_star'],['bi-shield-check','about_safe'],['bi-heart-fill','about_satisfaction']] as [$icon,$key])
                    <div class="col-6">
                        <div class="d-flex align-items-center gap-2">
                            <div style="color:var(--gold);font-size:.95rem;"><i class="bi {{ $icon }}"></i></div>
                            <span style="font-size:.85rem;font-weight:600;color:#e0e0e0;font-family:'Inter',sans-serif;">{{ __('site.'.$key) }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                <a href="{{ route('about') }}" class="btn btn-gold px-4 py-2 rounded-3">{{ __('site.about_learn_more') }}</a>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════ FEATURED ROOMS ═══════════════════════════════════════ --}}
<section id="featured-rooms" style="background:var(--bg-dark);padding:90px 0;">
    <div class="container">
        <div class="text-center mb-5 fade-up">
            <span class="sec-tag">{{ __('site.rooms_tag') }}</span>
            <h2 class="sec-title">{{ __('site.rooms_title') }}</h2>
            <div class="gold-line"></div>
            <p style="color:var(--text-sec);max-width:480px;margin:0 auto;font-family:'Inter',sans-serif;font-size:.93rem;line-height:1.8;">{{ __('site.rooms_sub') }}</p>
        </div>
        <div class="row g-4">
            @forelse($featuredRooms as $room)
            <div class="col-lg-4 col-md-6 fade-up">
                <div class="room-card-dark h-100">
                    <div class="room-img-wrap">
                        <img src="{{ $room->thumbnail_url }}" alt="{{ $room->name }}">
                        @if($room->breakfast_included)
                        <div class="position-absolute top-0 end-0 m-3">
                            <span style="background:rgba(15,15,16,.8);border:1px solid rgba(255,255,255,.15);color:#fff;font-size:.65rem;font-weight:700;padding:4px 10px;border-radius:6px;backdrop-filter:blur(8px);">
                                <i class="bi bi-cup-hot me-1"></i>{{ __('site.rooms_breakfast') }}
                            </span>
                        </div>
                        @endif
                    </div>
                    <div class="room-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 style="font-size:1.15rem;font-weight:700;color:#fff;margin:0;">{{ $room->translated_name }}</h5>
                            <span class="room-price">{{ $room->formatted_price }}</span>
                        </div>
                        <p style="color:var(--text-sec);font-size:.83rem;line-height:1.7;margin-bottom:1rem;font-family:'Inter',sans-serif;">
                            {{ Str::limit($room->translated_description, 95) }}
                        </p>
                        <div class="room-meta d-flex flex-wrap gap-2 mb-4">
                            <span><i class="bi bi-people me-1"></i>{{ $room->capacity }} {{ __('site.rooms_guests') }}</span>
                            <span><i class="bi bi-moon me-1"></i>{{ $room->beds }} {{ $room->beds > 1 ? __('site.rooms_beds') : __('site.rooms_bed') }}</span>
                            @if($room->has_wifi)<span><i class="bi bi-wifi me-1"></i>WiFi</span>@endif
                            @if($room->has_aircon)<span><i class="bi bi-wind me-1"></i>A/C</span>@endif
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('rooms.show', $room) }}" class="btn btn-outline-gold btn-sm flex-fill rounded-3">{{ __('site.rooms_view_details') }}</a>
                            @auth
                                <a href="{{ route('booking.create', $room->id) }}" class="btn btn-gold btn-sm flex-fill rounded-3">{{ __('site.rooms_book_now') }}</a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-gold btn-sm flex-fill rounded-3">{{ __('site.rooms_book_now') }}</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5" style="color:var(--text-sec);">{{ __('site.rooms_no_featured') }}</div>
            @endforelse
        </div>
        <div class="text-center mt-5 fade-up">
            <a href="{{ route('rooms.index') }}" class="btn btn-outline-gold btn-lg px-5 py-3 rounded-3">
                {{ __('site.rooms_view_all') }} <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════ FACILITIES ═══════════════════════════════════════ --}}
<section style="background:var(--surface-2);padding:90px 0;">
    <div class="container">
        <div class="text-center mb-5 fade-up">
            <span class="sec-tag">{{ __('site.fac_tag') }}</span>
            <h2 class="sec-title">{{ __('site.fac_title') }}</h2>
            <div class="gold-line"></div>
        </div>
        <div class="row g-4">
            @foreach($facilities as $facility)
            <div class="col-lg-4 col-md-6 fade-up">
                <div class="fac-card">
                    <div class="fac-icon"><i class="bi {{ $facility->icon ?? 'bi-building' }}"></i></div>
                    <h5 style="color:#fff;font-size:1.15rem;font-weight:700;margin-bottom:.6rem;">{{ $facility->translated_name }}</h5>
                    <p style="color:var(--text-sec);font-size:.83rem;line-height:1.75;margin-bottom:.6rem;font-family:'Inter',sans-serif;">{{ Str::limit($facility->translated_description, 100) }}</p>
                    @if($facility->operating_hours)
                    <small style="color:var(--gold);font-family:'Inter',sans-serif;font-size:.75rem;"><i class="bi bi-clock me-1"></i>{{ $facility->operating_hours }}</small>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-5">
            <a href="{{ route('facilities') }}" class="btn btn-outline-gold px-5 py-3 rounded-3">{{ __('site.fac_explore') }}</a>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════ PROMOTIONS ═══════════════════════════════════════ --}}
@if($promotions->count())
<section style="background:var(--bg-dark);padding:90px 0;">
    <div class="container">
        <div class="text-center mb-5 fade-up">
            <span class="sec-tag">{{ __('site.promo_tag') }}</span>
            <h2 class="sec-title">{{ __('site.promo_title') }}</h2>
            <div class="gold-line"></div>
        </div>
        <div class="row g-4 justify-content-center">
            @foreach($promotions as $promo)
            <div class="col-lg-4 col-md-6 fade-up">
                <div class="promo-card-dark h-100">
                    <span style="background:var(--gold);color:#101111;font-size:.72rem;font-weight:800;padding:4px 14px;border-radius:20px;display:inline-block;margin-bottom:.9rem;letter-spacing:.5px;font-family:'Inter',sans-serif;">
                        {{ $promo->discount_type === 'percentage' ? $promo->discount_value.'% OFF' : '₱'.number_format($promo->discount_value,0).' OFF' }}
                    </span>
                    <h5 style="color:#fff;font-weight:700;margin-bottom:.7rem;">{{ $promo->translated_title }}</h5>
                    <p style="color:rgba(255,255,255,.55);font-size:.85rem;line-height:1.75;font-family:'Inter',sans-serif;">{{ Str::limit($promo->translated_description, 100) }}</p>
                    <div style="margin-top:1.2rem;padding-top:1.2rem;border-top:1px solid rgba(255,255,255,.08);">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div style="font-size:.68rem;color:rgba(255,255,255,.4);font-family:'Inter',sans-serif;letter-spacing:1px;text-transform:uppercase;">{{ __('site.promo_code_label') }}</div>
                                <div style="font-weight:800;color:var(--gold);font-size:1.2rem;letter-spacing:3px;font-family:'Inter',sans-serif;">{{ $promo->code }}</div>
                            </div>
                            <a href="{{ route('rooms.index') }}" class="btn btn-gold btn-sm px-3 rounded-3">{{ __('site.rooms_book_now') }}</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ═══════════════════════════════════════ TESTIMONIALS ═══════════════════════════════════════ --}}
@if($testimonials->count())
<section style="background:var(--surface-2);padding:90px 0;">
    <div class="container">
        <div class="text-center mb-5 fade-up">
            <span class="sec-tag">{{ __('site.testi_tag') }}</span>
            <h2 class="sec-title">{{ __('site.testi_title') }}</h2>
            <div class="gold-line"></div>
        </div>
        <div class="row g-4">
            @foreach($testimonials as $t)
            <div class="col-lg-4 col-md-6 fade-up">
                <div class="testi-card">
                    <div class="star-g mb-3">
                        @for($i=0;$i<5;$i++)<i class="bi {{ $i < $t->rating ? 'bi-star-fill' : 'bi-star' }}"></i>@endfor
                    </div>
                    <p style="color:var(--text-sec);line-height:1.85;font-size:.9rem;margin-bottom:1.4rem;font-family:'Inter',sans-serif;">"{{ $t->translated_content }}"</p>
                    <div class="d-flex align-items-center gap-3">
                        <div style="width:44px;height:44px;border-radius:50%;background:linear-gradient(135deg,var(--gold),var(--gold-dark));display:flex;align-items:center;justify-content:center;color:#101111;font-weight:800;font-size:1.1rem;flex-shrink:0;">{{ substr($t->translated_guest_name,0,1) }}</div>
                        <div>
                            <div style="font-weight:600;font-size:.88rem;color:#fff;font-family:'Inter',sans-serif;">{{ $t->translated_guest_name }}</div>
                            @if($t->translated_guest_location)
                            <div style="font-size:.75rem;color:var(--text-sec);font-family:'Inter',sans-serif;"><i class="bi bi-geo-alt me-1"></i>{{ $t->translated_guest_location }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ═══════════════════════════════════════ CTA ═══════════════════════════════════════ --}}
<section class="cta-wrap" style="padding:100px 0;">
    <div class="container text-center fade-up">
        <span class="sec-tag" style="color:var(--gold-light);">{{ __('site.cta_tag') }}</span>
        <h2 class="sec-title mb-4">{{ __('site.cta_title') }}</h2>
        <p style="color:var(--text-sec);max-width:480px;margin:0 auto 2.5rem;line-height:1.85;font-family:'Inter',sans-serif;">{{ __('site.cta_sub') }}</p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="{{ route('rooms.index') }}" class="btn btn-gold btn-lg px-5 py-3 rounded-3">
                <i class="bi bi-calendar-plus me-2"></i>{{ __('site.cta_reserve') }}
            </a>
            <a href="{{ route('contact') }}" class="btn btn-outline-gold btn-lg px-5 py-3 rounded-3">
                <i class="bi bi-telephone me-2"></i>{{ __('site.cta_contact') }}
            </a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    // Fade-up scroll observer
    const io = new IntersectionObserver((entries) => {
        entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
    }, { threshold: 0.1 });
    document.querySelectorAll('.fade-up').forEach(el => io.observe(el));
</script>
@endpush
