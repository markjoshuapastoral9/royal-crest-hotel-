<div class="row g-3">
    <div class="col-md-8">
        <label class="form-label small fw-semibold">Promotion Title *</label>
        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
               value="{{ old('title', $promotion->title ?? '') }}" required>
        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label class="form-label small fw-semibold">Promo Code *</label>
        <input type="text" name="code" class="form-control @error('code') is-invalid @enderror"
               style="text-transform:uppercase;letter-spacing:2px;font-weight:bold;"
               value="{{ old('code', $promotion->code ?? '') }}" required>
        @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12">
        <label class="form-label small fw-semibold">Description</label>
        <textarea name="description" class="form-control" rows="3">{{ old('description', $promotion->description ?? '') }}</textarea>
    </div>
    <div class="col-md-4">
        <label class="form-label small fw-semibold">Discount Type *</label>
        <select name="discount_type" class="form-select" required>
            <option value="percentage" {{ old('discount_type', $promotion->discount_type ?? 'percentage') === 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
            <option value="fixed" {{ old('discount_type', $promotion->discount_type ?? '') === 'fixed' ? 'selected' : '' }}>Fixed Amount (₱)</option>
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label small fw-semibold">Discount Value *</label>
        <input type="number" name="discount_value" class="form-control @error('discount_value') is-invalid @enderror"
               value="{{ old('discount_value', $promotion->discount_value ?? '') }}" step="0.01" min="0" required>
        @error('discount_value')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label class="form-label small fw-semibold">Minimum Nights</label>
        <input type="number" name="minimum_nights" class="form-control" min="1"
               value="{{ old('minimum_nights', $promotion->minimum_nights ?? 1) }}">
    </div>
    <div class="col-md-4">
        <label class="form-label small fw-semibold">Valid From</label>
        <input type="date" name="valid_from" class="form-control"
               value="{{ old('valid_from', isset($promotion->valid_from) ? $promotion->valid_from->format('Y-m-d') : '') }}">
    </div>
    <div class="col-md-4">
        <label class="form-label small fw-semibold">Valid Until</label>
        <input type="date" name="valid_until" class="form-control"
               value="{{ old('valid_until', isset($promotion->valid_until) ? $promotion->valid_until->format('Y-m-d') : '') }}">
    </div>
    <div class="col-md-4">
        <label class="form-label small fw-semibold">Usage Limit</label>
        <input type="number" name="usage_limit" class="form-control" min="1" placeholder="Unlimited"
               value="{{ old('usage_limit', $promotion->usage_limit ?? '') }}">
    </div>
    <div class="col-12">
        <label class="form-label small fw-semibold">Banner Image</label>
        @if(isset($promotion) && $promotion->image)
            <div class="mb-2"><img src="{{ asset('storage/'.$promotion->image) }}" class="rounded-3" style="height:80px;object-fit:cover;" alt=""></div>
        @endif
        <input type="file" name="image" class="form-control form-control-sm" accept="image/*">
    </div>
    <div class="col-12">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="is_active" id="promo_active" value="1"
                   {{ old('is_active', $promotion->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label small" for="promo_active">Active Promotion</label>
        </div>
    </div>
</div>
