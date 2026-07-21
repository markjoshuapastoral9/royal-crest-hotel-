<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'image', 'category', 'imageable_type', 'imageable_id',
        'is_featured', 'sort_order',
    ];

    protected $casts = ['is_featured' => 'boolean'];

    public function imageable()
    {
        return $this->morphTo();
    }

    public function getImageUrlAttribute(): string
    {
        if (!$this->image) {
            return 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=600&q=80';
        }
        // If it's already an external URL return as-is
        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }
        return asset('storage/' . $this->image);
    }
}
