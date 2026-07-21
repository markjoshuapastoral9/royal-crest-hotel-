@extends('layouts.app')
@section('title', __('site.cp_title'))

@push('styles')
<style>
@media (max-width: 576px) {
    .d-flex.align-items-center.gap-4 { flex-direction: column; align-items: flex-start !important; gap: 1rem !important; }
    .bg-white.rounded-4.p-4 { padding: 1.2rem !important; }
    section[style] { padding: 25px 0 !important; }
}
</style>
@endpush

@section('content')
<div class="page-hero">
    <div class="container">
        <h1 class="text-white">{{ __('site.cp_title') }}</h1>
        <p class="text-white-50">{{ __('site.cp_subtitle') }}</p>
    </div>
</div>

<section style="padding:50px 0; background:#F8F7F4;">
<div class="container">
    <div class="row g-4 justify-content-center">
        <div class="col-lg-8">
            <!-- Profile Info -->
            <div class="bg-white rounded-4 p-4 shadow-sm mb-4">
                <h5 class="fw-bold mb-4">{{ __('site.cp_personal_info') }}</h5>
                <form method="POST" action="{{ route('customer.profile.update') }}" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="d-flex align-items-center gap-4 mb-4">
                        <img src="{{ $user->avatar_url }}" class="rounded-circle" width="80" height="80" style="object-fit:cover;" id="avatarPreview">
                        <div>
                            <label class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-camera me-1"></i>{{ __('site.cp_change_photo') }}
                                <input type="file" name="avatar" class="d-none" accept="image/*" onchange="previewAvatar(this)">
                            </label>
                            <div class="text-muted mt-1" style="font-size:.75rem;">{{ __('site.cp_photo_hint') }}</div>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">{{ __('site.cp_fullname') }}</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">{{ __('site.cp_email') }}</label>
                            <input type="email" class="form-control bg-light" value="{{ $user->email }}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">{{ __('site.cp_phone') }}</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}">
                            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-semibold">{{ __('site.cp_address') }}</label>
                            <textarea name="address" class="form-control" rows="2">{{ old('address', $user->address) }}</textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-gold mt-4 px-4">{{ __('site.cp_save') }}</button>
                </form>
            </div>

            <!-- Change Password -->
            <div class="bg-white rounded-4 p-4 shadow-sm">
                <h5 class="fw-bold mb-4">{{ __('site.cp_change_pwd') }}</h5>
                <form method="POST" action="{{ route('customer.profile.password') }}">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label small fw-semibold">{{ __('site.cp_current_pwd') }}</label>
                            <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                            @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">{{ __('site.cp_new_pwd') }}</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">{{ __('site.cp_confirm_pwd') }}</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-gold mt-4 px-4">{{ __('site.cp_update_pwd') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
</section>
@endsection

@push('scripts')
<script>
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => document.getElementById('avatarPreview').src = e.target.result;
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
