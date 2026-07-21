@extends('layouts.app')
@section('title', __('site.fac_page_title'))

@push('styles')
<style>
.fac-hero { background: linear-gradient(135deg, #101111 0%, #1e1613 50%, #101111 100%); padding: 100px 0 60px; border-bottom: 1px solid rgba(166,130,74,.2); }
.fac-card { background: #1e1a1b; border: 1px solid rgba(166,130,74,.2); border-radius: 20px; overflow: hidden; display: flex; transition: all .35s; height: 100%; }
.fac-card:hover { border-color: rgba(166,130,74,.45); transform: translateY(-5px); box-shadow: 0 16px 40px rgba(0,0,0,.5); }
.fac-img { width: 160px; flex-shrink: 0; object-fit: cover; }
.fac-icon-wrap { width: 140px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #1a1210, #2a1c0e); border-right: 1px solid rgba(166,130,74,.15); font-size: 2.8rem; color: #A6824A; }
.fac-body { padding: 1.6rem 1.8rem; display: flex; flex-direction: column; justify-content: center; }
.fac-title { color: #E6E2DA; font-size: 1.1rem; font-weight: 700; margin-bottom: .5rem; font-family: 'Playfair Display', serif; display: flex; align-items: center; gap: 8px; }
.fac-title i { color: #A6824A; font-size: 1rem; }
.fac-desc { color: #9a9189; font-size: .85rem; line-height: 1.8; margin-bottom: .8rem; font-family: 'Inter', sans-serif; }
.fac-hours { display: inline-flex; align-items: center; gap: 6px; background: rgba(166,130,74,.1); border: 1px solid rgba(166,130,74,.2); color: #C9A87C; font-size: .75rem; font-weight: 600; padding: 4px 12px; border-radius: 20px; font-family: 'Inter', sans-serif; }
.cta-card { background: linear-gradient(135deg, #1e1a1b 0%, #2a1c0e 50%, #1e1a1b 100%); border: 1px solid rgba(166,130,74,.25); border-radius: 24px; padding: 3.5rem 2rem; text-align: center; max-width: 580px; margin: 0 auto; }
.cta-card h4 { color: #E6E2DA; font-family: 'Playfair Display', serif; margin-bottom: .75rem; }
.cta-card p  { color: #9a9189; font-size: .92rem; line-height: 1.8; margin-bottom: 1.8rem; }
@media (max-width: 768px) {
    .fac-hero { padding: 80px 0 40px; }
    .fac-card { flex-direction: column; }
    .fac-img, .fac-icon-wrap { width: 100%; height: 160px; border-right: none; border-bottom: 1px solid rgba(166,130,74,.15); }
    .fac-body { padding: 1.2rem; }
    section[style] { padding: 50px 0 !important; }
}
</style>
@endpush

@section('content')

{{-- Hero --}}
<div class="fac-hero">
    <div class="container text-center">
        <span class="section-tag">{{ __('site.fac_page_tag') }}</span>
        <h1 class="mt-2" style="color:#E6E2DA;font-family:'Playfair Display',serif;font-size:clamp(1.8rem,4vw,3rem);">{{ __('site.fac_page_title') }}</h1>
        <p style="color:#9a9189;font-family:'Inter',sans-serif;font-size:.95rem;margin-top:.5rem;">{{ __('site.fac_page_subtitle') }}</p>
    </div>
</div>

{{-- Facilities Grid --}}
<section style="padding:80px 0;background:#101111;">
<div class="container">
    @if($facilities->count())
    <div class="row g-4">
        @foreach($facilities as $facility)
        <div class="col-lg-6 fade-up">
            <div class="fac-card">
                @if($facility->image)
                    <img src="{{ $facility->image_url }}" class="fac-img" alt="{{ $facility->translated_name }}">
                @else
                    <div class="fac-icon-wrap">
                        <i class="bi {{ $facility->icon ?? 'bi-building' }}"></i>
                    </div>
                @endif
                <div class="fac-body">
                    <div class="fac-title">
                        <i class="bi {{ $facility->icon ?? 'bi-building' }}"></i>
                        {{ $facility->translated_name }}
                    </div>
                    <p class="fac-desc">{{ $facility->translated_description }}</p>
                    @if($facility->operating_hours)
                    <div>
                        <span class="fac-hours">
                            <i class="bi bi-clock"></i>{{ $facility->operating_hours }}
                        </span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-5" style="color:#9a9189;">
        <i class="bi bi-building" style="font-size:3rem;color:rgba(166,130,74,.3);display:block;margin-bottom:1rem;"></i>
        <p>{{ __('site.fac_coming_soon') }}</p>
    </div>
    @endif

    {{-- CTA --}}
    <div class="text-center mt-5 pt-3 fade-up">
        <div class="cta-card">
            <i class="bi bi-calendar-check" style="font-size:2.5rem;color:#A6824A;display:block;margin-bottom:1rem;"></i>
            <h4>{{ __('site.fac_cta_title') }}</h4>
            <p>{{ __('site.fac_cta_desc') }}</p>
            <a href="{{ route('rooms.index') }}" class="btn btn-gold btn-lg px-5 py-3 rounded-3">{{ __('site.fac_cta_btn') }}</a>
        </div>
    </div>
</div>
</section>

@endsection
