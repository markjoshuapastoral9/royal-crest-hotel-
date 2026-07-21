@extends('layouts.admin')
@section('title', 'Settings')
@section('breadcrumb')<li class="breadcrumb-item active">Settings</li>@endsection

@section('content')
<h4 class="fw-bold mb-4">Website Settings</h4>

<form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
@csrf
<div class="row g-4">
    <div class="col-lg-8">
        <div class="admin-card p-4 mb-4">
            <h6 class="fw-bold mb-3">General Information</h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Hotel Name</label>
                    <input type="text" name="hotel_name" class="form-control" value="{{ $settings['hotel_name']->value ?? 'Monarch Hotel' }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Tagline</label>
                    <input type="text" name="hotel_tagline" class="form-control" value="{{ $settings['hotel_tagline']->value ?? '' }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Email Address</label>
                    <input type="email" name="hotel_email" class="form-control" value="{{ $settings['hotel_email']->value ?? '' }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Phone Number</label>
                    <input type="text" name="hotel_phone" class="form-control" value="{{ $settings['hotel_phone']->value ?? '' }}" required>
                </div>
                <div class="col-12">
                    <label class="form-label small fw-semibold">Address</label>
                    <input type="text" name="hotel_address" class="form-control" value="{{ $settings['hotel_address']->value ?? '' }}" required>
                </div>
                <div class="col-12">
                    <label class="form-label small fw-semibold">Hotel Description</label>
                    <textarea name="hotel_description" class="form-control" rows="3">{{ $settings['hotel_description']->value ?? '' }}</textarea>
                </div>
            </div>
        </div>

        <div class="admin-card p-4 mb-4">
            <h6 class="fw-bold mb-3">Booking Policy</h6>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Check-in Time</label>
                    <input type="text" name="check_in_time" class="form-control" value="{{ $settings['check_in_time']->value ?? '2:00 PM' }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Check-out Time</label>
                    <input type="text" name="check_out_time" class="form-control" value="{{ $settings['check_out_time']->value ?? '12:00 PM' }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Tax Rate (%)</label>
                    <input type="number" name="tax_rate" class="form-control" value="{{ $settings['tax_rate']->value ?? 12 }}" min="0" max="100" step="0.01" required>
                </div>
            </div>
        </div>

        <div class="admin-card p-4 mb-4">
            <h6 class="fw-bold mb-3">Social Media</h6>
            <div class="row g-3">
                @foreach([['facebook_url','bi-facebook','Facebook URL'],['instagram_url','bi-instagram','Instagram URL'],['twitter_url','bi-twitter-x','Twitter/X URL'],['google_maps_url','bi-geo-alt','Google Maps URL']] as [$key,$icon,$label])
                <div class="col-md-6">
                    <label class="form-label small fw-semibold"><i class="bi {{ $icon }} me-1 text-gold"></i>{{ $label }}</label>
                    <input type="url" name="{{ $key }}" class="form-control" value="{{ $settings[$key]->value ?? '' }}">
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="admin-card p-4">
            <h6 class="fw-bold mb-3">Hotel Logo</h6>
            @if(isset($settings['hotel_logo']) && $settings['hotel_logo']->value)
            <img src="{{ asset('storage/'.$settings['hotel_logo']->value) }}" class="img-fluid rounded-3 mb-3" style="max-height:120px;" alt="Logo">
            @endif
            <input type="file" name="hotel_logo" class="form-control form-control-sm" accept="image/*">
            <div class="form-text">PNG, SVG recommended. Max 2MB.</div>
        </div>
    </div>
</div>

<button type="submit" class="btn btn-gold px-5 mt-2">Save Settings</button>
</form>
@endsection
