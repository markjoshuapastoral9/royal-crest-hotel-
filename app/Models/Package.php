<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'original_price',
        'min_nights',
        'inclusions',
        'image',
        'is_featured',
        'is_active',
        'sort_order',
        'valid_from',
        'valid_until',
    ];

    protected $casts = [
        'inclusions' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'valid_from' => 'date',
        'valid_until' => 'date',
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($package) {
            if (empty($package->slug)) {
                $package->slug = Str::slug($package->name);
            }
        });
    }

    // Relationships
    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'package_amenity')
                    ->withTimestamps();
    }

    public function bookings()
    {
        return $this->belongsToMany(Booking::class, 'booking_package')
                    ->withPivot('package_price')
                    ->withTimestamps();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->where('is_active', true);
    }

    public function scopeValid($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('valid_from')
              ->orWhere('valid_from', '<=', now());
        })->where(function ($q) {
            $q->whereNull('valid_until')
              ->orWhere('valid_until', '>=', now());
        });
    }

    // Accessors
    public function getDiscountPercentageAttribute()
    {
        if ($this->original_price && $this->original_price > $this->price) {
            return round((($this->original_price - $this->price) / $this->original_price) * 100);
        }
        return 0;
    }

    public function getSavingsAttribute()
    {
        if ($this->original_price && $this->original_price > $this->price) {
            return $this->original_price - $this->price;
        }
        return 0;
    }

    public function getInclusionListAttribute()
    {
        $inclusionMap = [
            'room' => '🛏️ Accommodation',
            'breakfast' => '🍳 Daily Breakfast',
            'lunch' => '🍱 Lunch',
            'dinner' => '🍽️ Dinner',
            'spa' => '💆 Spa Treatment',
            'massage' => '💆 Massage Session',
            'wifi' => '📶 Free WiFi',
            'airport_transfer' => '✈️ Airport Transfer',
            'late_checkout' => '🕐 Late Check-out',
            'welcome_drink' => '🍹 Welcome Drink',
        ];

        return collect($this->inclusions)->map(function ($item) use ($inclusionMap) {
            return $inclusionMap[$item] ?? ucfirst(str_replace('_', ' ', $item));
        })->toArray();
    }
}
