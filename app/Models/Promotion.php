<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'code', 'description', 'image',
        'discount_type', 'discount_value', 'minimum_nights', 'minimum_amount',
        'valid_from', 'valid_until', 'usage_limit', 'used_count', 'is_active',
    ];

    protected $casts = [
        'valid_from' => 'date',
        'valid_until' => 'date',
        'is_active' => 'boolean',
        'discount_value' => 'decimal:2',
        'title_translations' => 'array',
        'description_translations' => 'array',
    ];

    public function getTranslatedTitleAttribute(): string
    {
        $locale = app()->getLocale();
        if ($locale === 'en' || !$this->title_translations) return $this->title;
        return $this->title_translations[$locale] ?? $this->title;
    }

    public function getTranslatedDescriptionAttribute(): string
    {
        $locale = app()->getLocale();
        if ($locale === 'en' || !$this->description_translations) return $this->description;
        return $this->description_translations[$locale] ?? $this->description;
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function isValid(): bool
    {
        if (!$this->is_active) return false;
        $now = Carbon::today();
        if ($this->valid_from && $now->lt(Carbon::parse($this->valid_from)->startOfDay())) return false;
        if ($this->valid_until && $now->gt(Carbon::parse($this->valid_until)->endOfDay())) return false;
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) return false;
        return true;
    }

    public function calculateDiscount(float $amount): float
    {
        if ($this->discount_type === 'percentage') {
            return round($amount * ($this->discount_value / 100), 2);
        }
        return min($this->discount_value, $amount);
    }
}
