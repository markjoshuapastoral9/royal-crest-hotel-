@extends('layouts.app')
@section('title', __('site.con_title'))

@push('styles')
<style>
.contact-hero { background: linear-gradient(135deg, #101111 0%, #1e1613 50%, #101111 100%); padding: 100px 0 60px; border-bottom: 1px solid rgba(166,130,74,.2); }
.contact-info-card { background: #1e1a1b; border: 1px solid rgba(166,130,74,.2); border-radius: 20px; padding: 2rem; height: 100%; }
.contact-info-card h4 { color: #E6E2DA; font-family: 'Playfair Display', serif; margin-bottom: 1.8rem; }
.contact-item { display: flex; gap: 1rem; margin-bottom: 1.5rem; align-items: flex-start; }
.contact-icon { width: 44px; height: 44px; border-radius: 10px; flex-shrink: 0; background: linear-gradient(135deg, #A6824A, #7A5E32); display: flex; align-items: center; justify-content: center; color: #101111; font-size: 1rem; }
.contact-label { font-size: .72rem; color: #9a9189; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 3px; font-family: 'Inter', sans-serif; }
.contact-val { color: #E6E2DA; font-size: .9rem; font-weight: 600; font-family: 'Inter', sans-serif; }
.social-btn { width: 40px; height: 40px; border-radius: 10px; background: rgba(255,255,255,.06); border: 1px solid rgba(166,130,74,.2); display: flex; align-items: center; justify-content: center; color: #B8AFA6; font-size: 1rem; text-decoration: none; transition: all .25s; }
.social-btn:hover { background: #A6824A; color: #101111; border-color: #A6824A; }
.form-card { background: #1e1a1b; border: 1px solid rgba(166,130,74,.2); border-radius: 20px; padding: 2rem; }
.form-card h4 { color: #E6E2DA; font-family: 'Playfair Display', serif; margin-bottom: 1.5rem; }
.form-card .form-label { color: #9a9189; font-size: .75rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; margin-bottom: .4rem; }
.form-card .form-control, .form-card .form-select { background: rgba(255,255,255,.05) !important; border: 1px solid rgba(166,130,74,.2) !important; color: #E6E2DA !important; border-radius: 10px; padding: 11px 14px; font-size: .88rem; font-family: 'Inter', sans-serif; }
.form-card .form-control:focus, .form-card .form-select:focus { border-color: #A6824A !important; box-shadow: 0 0 0 3px rgba(166,130,74,.12) !important; background: rgba(255,255,255,.08) !important; }
.form-card .form-control::placeholder { color: rgba(184,175,166,.3) !important; }
.form-card .form-select option { background: #1e1a1b; color: #E6E2DA; }
.map-card { background: #1e1a1b; border: 1px solid rgba(166,130,74,.2); border-radius: 20px; overflow: hidden; height: 100%; }
.map-card-header { padding: 1.4rem 1.6rem; border-bottom: 1px solid rgba(166,130,74,.12); }
.map-card-header h6 { color: #E6E2DA; font-weight: 700; font-size: .95rem; margin-bottom: .2rem; font-family: 'Inter', sans-serif; }
.map-card-header p { color: #9a9189; font-size: .8rem; margin: 0; }
.map-card-footer { padding: 1rem 1.2rem; border-top: 1px solid rgba(166,130,74,.12); }
.alert-success-dark { background: rgba(21,66,48,.25); border: 1px solid rgba(74,222,128,.2); color: #4ade80; border-radius: 10px; padding: 10px 14px; font-size: .85rem; margin-bottom: 1.2rem; }
@media (max-width: 768px) { .contact-hero { padding: 80px 0 40px; } section[style] { padding: 50px 0 !important; } }
</style>
@endpush

@section('content')

{{-- Hero --}}
<div class="contact-hero">
    <div class="container text-center">
        <span class="section-tag">{{ __('site.con_tag') }}</span>
        <h1 class="mt-2" style="color:#E6E2DA;font-family:'Playfair Display',serif;font-size:clamp(1.8rem,4vw,3rem);">{{ __('site.con_title') }}</h1>
        <p style="color:#9a9189;font-family:'Inter',sans-serif;font-size:.95rem;margin-top:.5rem;">{{ __('site.con_subtitle') }}</p>
    </div>
</div>

<section style="padding:80px 0;background:#101111;">
<div class="container">
    <div class="row g-4">

        {{-- Contact Info --}}
        <div class="col-lg-4 fade-up">
            <div class="contact-info-card">
                <h4>{{ __('site.con_reach_us') }}</h4>
                @foreach([
                    ['bi-geo-alt-fill',       'con_address_label',    'Calasiao, Pangasinan 2418, Philippines'],
                    ['bi-telephone-fill',     'con_phone_label',      '+63 75 123 4567'],
                    ['bi-envelope-fill',      'con_email_label',      'info@royalcresthotel.com'],
                    ['bi-clock-fill',         'con_checkinout_label', '2:00 PM / 12:00 PM'],
                    ['bi-calendar-check-fill','con_reservations',     null],
                ] as [$icon, $labelKey, $val])
                <div class="contact-item">
                    <div class="contact-icon"><i class="bi {{ $icon }}"></i></div>
                    <div>
                        <div class="contact-label">{{ __('site.'.$labelKey) }}</div>
                        <div class="contact-val">{{ $val ?? __('site.con_open_24') }}</div>
                    </div>
                </div>
                @endforeach

                <div class="mt-3 pt-3" style="border-top:1px solid rgba(166,130,74,.12);">
                    <div class="contact-label mb-3">{{ __('site.con_follow_us') }}</div>
                    <div class="d-flex gap-2">
                        <a href="https://facebook.com" class="social-btn"><i class="bi bi-facebook"></i></a>
                        <a href="https://instagram.com" class="social-btn"><i class="bi bi-instagram"></i></a>
                        <a href="https://twitter.com" class="social-btn"><i class="bi bi-twitter-x"></i></a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Contact Form --}}
        <div class="col-lg-5 fade-up">
            <div class="form-card">
                <h4>{{ __('site.con_send_msg') }}</h4>

                @if(session('success'))
                <div class="alert-success-dark">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                </div>
                @endif

                <form method="POST" action="{{ route('contact.submit') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">{{ __('site.con_fullname') }}</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}" placeholder="{{ __('site.con_placeholder_name') }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">{{ __('site.con_email_field') }}</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" placeholder="your@email.com" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">{{ __('site.con_phone_field') }}</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="+63 9xx xxx xxxx">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">{{ __('site.con_subject_field') }}</label>
                        <select name="subject" class="form-select @error('subject') is-invalid @enderror" required>
                            <option value="">{{ __('site.con_select_subject') }}</option>
                            @foreach(__('site.con_subjects') as $s)
                            <option value="{{ $s }}" {{ old('subject') === $s ? 'selected' : '' }}>{{ $s }}</option>
                            @endforeach
                        </select>
                        @error('subject')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ __('site.con_message') }}</label>
                        <textarea name="message" class="form-control @error('message') is-invalid @enderror"
                                  rows="5" placeholder="{{ __('site.con_placeholder_msg') }}" required>{{ old('message') }}</textarea>
                        @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-gold w-100 py-3 fw-semibold rounded-3">
                            <i class="bi bi-send me-2"></i>{{ __('site.con_send_btn') }}
                        </button>
                    </div>
                </div>
                </form>
            </div>
        </div>

        {{-- Map --}}
        <div class="col-lg-3 fade-up">
            <div class="map-card">
                <div class="map-card-header">
                    <h6><i class="bi bi-geo-alt me-2" style="color:#A6824A;"></i>{{ __('site.con_map_title') }}</h6>
                    <p>Calasiao, Pangasinan, Philippines</p>
                </div>
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d30815.748889!2d120.3688!3d16.0159!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x339608a6c5ab3a87%3A0x1234567890abcdef!2sCalasiao%2C+Pangasinan!5e0!3m2!1sen!2sph!4v1600000000000"
                    width="100%" height="280" style="border:0;display:block;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
                <div class="map-card-footer">
                    <a href="https://maps.google.com/?q=Calasiao+Pangasinan" target="_blank"
                       class="btn btn-outline-gold btn-sm w-100">
                        <i class="bi bi-map me-1"></i>{{ __('site.con_open_maps') }}
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
</section>

@endsection
