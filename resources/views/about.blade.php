@extends('layouts.app')
@section('title', __('site.about_page_title'))

@section('content')
<div class="page-hero">
    <div class="container text-center">
        <span class="section-tag">{{ __('site.about_page_tag') }}</span>
        <h1 class="mt-2 text-white">{{ __('site.about_page_title') }}</h1>
        <p class="text-white-50">{{ __('site.about_page_subtitle') }}</p>
    </div>
</div>

<section style="padding:80px 0;">
    <div class="container">
        <div class="row align-items-center g-5 mb-6">
            <div class="col-lg-6 fade-up">
                <img src="https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=700&q=80"
                     class="img-fluid rounded-4 shadow-lg" alt="Monarch Hotel Lobby">
            </div>
            <div class="col-lg-6 fade-up">
                <span class="section-tag">{{ __('site.about_heritage_tag') }}</span>
                <h2 class="section-title">{{ __('site.about_heritage_title') }}</h2>
                <div class="section-divider left"></div>
                <p class="text-muted mb-4" style="line-height:1.9;">{{ __('site.about_body_p1') }}</p>
                <p class="text-muted mb-4" style="line-height:1.9;">{{ __('site.about_body_p2') }}</p>
                <div class="row g-3">
                    @foreach([['25+','about_stat_years'],['500+','about_stat_events'],['10,000+','about_stat_guests'],['20+','about_stat_cats']] as [$num,$key])
                    <div class="col-6">
                        <div class="text-center p-3 bg-light rounded-3">
                            <div style="font-family:'Playfair Display',serif;font-size:2.2rem;color:var(--gold);font-weight:700;">{{ $num }}</div>
                            <div class="small text-muted fw-semibold">{{ __('site.'.$key) }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Mission Vision Values -->
        <div class="row g-4 mb-5">
            @foreach([
                ['bi-bullseye','about_mission_tag','about_mission_desc'],
                ['bi-eye','about_vision_tag','about_vision_desc'],
                ['bi-heart','about_values_tag','about_values_desc']
            ] as [$icon,$titleKey,$descKey])
            <div class="col-md-4 fade-up">
                <div class="text-center p-4 bg-white rounded-4 shadow-sm h-100" style="border-top:4px solid var(--gold);">
                    <div class="text-gold fs-1 mb-3"><i class="bi {{ $icon }}"></i></div>
                    <h5 class="fw-bold mb-3">{{ __('site.'.$titleKey) }}</h5>
                    <p class="text-muted small" style="line-height:1.8;">{{ __('site.'.$descKey) }}</p>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Team -->
        <div class="text-center mb-5 fade-up">
            <span class="section-tag">{{ __('site.about_leadership_tag') }}</span>
            <h2 class="section-title">{{ __('site.about_team_title') }}</h2>
            <div class="section-divider"></div>
        </div>
        <div class="row g-4 justify-content-center">
            @foreach([
                ['Ricardo Santos','about_gm_role','about_gm_bio'],
                ['Maria dela Cruz','about_chef_role','about_chef_bio'],
                ['Grace Villanueva','about_dir_role','about_dir_bio']
            ] as [$name,$roleKey,$bioKey])
            <div class="col-md-4 text-center fade-up">
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3 text-white fw-bold fs-2"
                     style="width:100px;height:100px;background:linear-gradient(135deg,var(--gold),var(--gold-dark));">
                    {{ substr($name,0,1) }}
                </div>
                <h5 class="fw-bold mb-1">{{ $name }}</h5>
                <div class="text-gold small fw-semibold mb-2">{{ __('site.'.$roleKey) }}</div>
                <p class="text-muted small">{{ __('site.'.$bioKey) }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA -->
<section style="padding:60px 0;background:linear-gradient(135deg,#101111 0%,#1a120a 50%,#101111 100%);border-top:1px solid var(--border);border-bottom:1px solid var(--border);">
    <div class="container text-center">
        <h2 class="section-title mb-3" style="color:#fff;">{{ __('site.about_cta_title') }}</h2>
        <p class="text-muted mb-4">{{ __('site.about_cta_desc') }}</p>
        <a href="{{ route('rooms.index') }}" class="btn btn-gold btn-lg px-5 py-3 rounded-3">{{ __('site.about_cta_btn') }}</a>
    </div>
</section>
@endsection
