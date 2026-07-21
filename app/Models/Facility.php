<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'icon', 'image',
        'operating_hours', 'is_featured', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'name_translations' => 'array',
        'description_translations' => 'array',
    ];

    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=600&q=80';
    }

    /** Get translated name based on current locale */
    public function getTranslatedNameAttribute(): string
    {
        $locale = app()->getLocale();
        
        if ($locale === 'en' || !$this->name_translations) {
            return $this->name;
        }

        return $this->name_translations[$locale] ?? $this->name;
    }

    /** Get translated description based on current locale */
    public function getTranslatedDescriptionAttribute(): string
    {
        $locale = app()->getLocale();
        
        if ($locale === 'en' || !$this->description_translations) {
            return $this->description;
        }

        return $this->description_translations[$locale] ?? $this->description;
    }
}
