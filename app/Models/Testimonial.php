<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'guest_name', 'guest_location', 'avatar', 'content', 'rating',
        'is_featured', 'is_active',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'content_translations' => 'array',
        'guest_name_translations' => 'array',
        'guest_location_translations' => 'array',
    ];

    /** Get translated content based on current locale */
    public function getTranslatedContentAttribute(): string
    {
        $locale = app()->getLocale();
        
        if ($locale === 'en' || !$this->content_translations) {
            return $this->content;
        }

        return $this->content_translations[$locale] ?? $this->content;
    }

    /** Get translated guest name based on current locale */
    public function getTranslatedGuestNameAttribute(): string
    {
        $locale = app()->getLocale();
        
        if ($locale === 'en' || !$this->guest_name_translations) {
            return $this->guest_name;
        }

        return $this->guest_name_translations[$locale] ?? $this->guest_name;
    }

    /** Get translated guest location based on current locale */
    public function getTranslatedGuestLocationAttribute(): ?string
    {
        $locale = app()->getLocale();
        
        if ($locale === 'en' || !$this->guest_location_translations) {
            return $this->guest_location;
        }

        return $this->guest_location_translations[$locale] ?? $this->guest_location;
    }
}
