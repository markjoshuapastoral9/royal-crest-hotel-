<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_type_id', 'room_number', 'name', 'description',
        'price_per_night', 'capacity', 'beds', 'bathrooms', 'floor', 'size_sqm',
        'has_wifi', 'has_aircon', 'has_tv', 'has_minibar', 'breakfast_included',
        'view', 'status', 'thumbnail', 'is_featured',
    ];

    protected $casts = [
        'has_wifi' => 'boolean',
        'has_aircon' => 'boolean',
        'has_tv' => 'boolean',
        'has_minibar' => 'boolean',
        'breakfast_included' => 'boolean',
        'is_featured' => 'boolean',
        'price_per_night' => 'decimal:2',
        'name_translations' => 'array',
        'description_translations' => 'array',
    ];

    /** Relationships */
    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function galleries()
    {
        return $this->morphMany(Gallery::class, 'imageable');
    }

    /** Check if room is available for given dates */
    public function isAvailableFor(string $checkIn, string $checkOut, ?int $excludeBookingId = null): bool
    {
        $query = $this->bookings()
            ->whereNotIn('status', ['cancelled', 'completed'])
            ->where(function ($q) use ($checkIn, $checkOut) {
                $q->whereBetween('check_in', [$checkIn, $checkOut])
                  ->orWhereBetween('check_out', [$checkIn, $checkOut])
                  ->orWhere(function ($q2) use ($checkIn, $checkOut) {
                      $q2->where('check_in', '<=', $checkIn)
                         ->where('check_out', '>=', $checkOut);
                  });
            });

        if ($excludeBookingId) {
            $query->where('id', '!=', $excludeBookingId);
        }

        return $query->count() === 0;
    }

    /** Scopes */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function getThumbnailUrlAttribute(): string
    {
        // PRIORITY 1: Use local room images from public/images/rooms/
        // This matches your actual room photos in the assets folder
        if ($local = $this->getLocalRoomImageUrl()) {
            return $local;
        }

        // PRIORITY 2: Check if thumbnail field has a value
        if ($this->thumbnail) {
            if (str_starts_with($this->thumbnail, 'http')) {
                return $this->thumbnail;
            }

            if (str_starts_with($this->thumbnail, 'images/')) {
                return asset($this->thumbnail);
            }

            if (Storage::disk('public')->exists($this->thumbnail)) {
                return asset('storage/' . $this->thumbnail);
            }
        }

        // FALLBACK ONLY: If no local image found, use placeholder
        // This should rarely happen if your room images are properly named
        $photos = [
            'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=600&q=80',
            'https://images.unsplash.com/photo-1611892440504-42a792e24d32?w=600&q=80',
            'https://images.unsplash.com/photo-1590490360182-c33d57733427?w=600&q=80',
            'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=600&q=80',
            'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=600&q=80',
            'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=600&q=80',
        ];
        return $photos[$this->id % count($photos)];
    }

    private function getLocalRoomImageUrl(): ?string
    {
        $filename = $this->getLocalRoomImageFilename();
        if (!$filename) {
            return null;
        }
        return asset('images/rooms/' . rawurlencode($filename));
    }

    private function getLocalRoomImageFilename(): ?string
    {
        $directory = public_path('images/rooms');
        if (!is_dir($directory)) {
            \Log::warning('Room images directory not found', ['path' => $directory]);
            return null;
        }

        $target = $this->normalizeRoomName($this->name);
        \Log::info('Looking for room image', [
            'room_name' => $this->name,
            'target_normalized' => $target,
        ]);
        
        // First pass: Exact match (strip numbers like "1. ", "10. ", etc)
        foreach (scandir($directory) as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }
            $name = pathinfo($file, PATHINFO_FILENAME);
            $originalName = $name;
            // Remove leading numbers and period (e.g., "1. Garden Deluxe" -> "Garden Deluxe")
            $name = preg_replace('/^\d+\.\s*/', '', $name);
            $normalized = $this->normalizeRoomName($name);
            
            if ($normalized === $target) {
                \Log::info('EXACT MATCH FOUND!', [
                    'file' => $file,
                    'original' => $originalName,
                    'stripped' => $name,
                    'normalized' => $normalized,
                ]);
                return $file;
            }
        }

        \Log::info('No exact match, trying partial match');
        
        // Second pass: Partial match
        foreach (scandir($directory) as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }
            $name = pathinfo($file, PATHINFO_FILENAME);
            $name = preg_replace('/^\d+\.\s*/', '', $name);
            $normalized = $this->normalizeRoomName($name);
            if (str_contains($normalized, $target) || str_contains($target, $normalized)) {
                \Log::info('PARTIAL MATCH FOUND!', [
                    'file' => $file,
                    'normalized' => $normalized,
                ]);
                return $file;
            }
        }

        \Log::warning('NO MATCH FOUND for room', ['room_name' => $this->name, 'target' => $target]);
        return null;
    }

    private function normalizeRoomName(string $value): string
    {
        return trim(preg_replace('/[^a-z0-9]+/', ' ', strtolower($value)));
    }

    /**
     * Get email-safe thumbnail URL
     * For emails, use absolute URLs that work in email clients
     */
    public function getEmailThumbnailUrlAttribute(): string
    {
        \Log::info('=== EMAIL THUMBNAIL START ===', ['room' => $this->name]);
        
        // Priority 1: Try to get local room image
        $localFile = $this->getLocalRoomImageFilename();
        
        if (!$localFile) {
            \Log::error('❌ NO LOCAL FILE FOUND', ['room_name' => $this->name]);
            // Fallback to Unsplash for now (you'll see which rooms have no images)
            $photos = [
                'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=800&q=80',
                'https://images.unsplash.com/photo-1611892440504-42a792e24d32?w=800&q=80',
                'https://images.unsplash.com/photo-1590490360182-c33d57733427?w=800&q=80',
            ];
            return $photos[$this->id % count($photos)];
        }
        
        $imagePath = public_path('images/rooms/' . $localFile);
        
        if (!file_exists($imagePath)) {
            \Log::error('❌ IMAGE FILE NOT FOUND', ['path' => $imagePath]);
            return 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=800&q=80';
        }
        
        $fileSize = filesize($imagePath);
        \Log::info('✅ Image file exists', [
            'path' => $imagePath,
            'size_kb' => round($fileSize / 1024, 2),
        ]);
        
        // For localhost, ALWAYS use base64
        $isLocal = config('app.env') === 'local' || 
                   str_contains(config('app.url') ?? '', 'localhost') ||
                   str_contains(config('app.url') ?? '', '127.0.0.1');
        
        if (!$isLocal) {
            \Log::info('Production mode - using asset URL');
            return asset('images/rooms/' . rawurlencode($localFile));
        }
        
        // LOCALHOST: Must use base64 for Gmail
        try {
            // Try compression for large images
            if ($fileSize > 500000) {
                \Log::info('🔄 Attempting compression (file > 500KB)');
                $compressedImage = $this->getCompressedImageBase64($imagePath);
                if ($compressedImage) {
                    \Log::info('✅ Compression SUCCESS', ['original_kb' => round($fileSize / 1024, 2)]);
                    return $compressedImage;
                }
                \Log::warning('⚠️ Compression FAILED - trying direct base64');
            }
            
            // Direct base64 for small images or if compression failed
            if ($fileSize < 3000000) {
                \Log::info('📦 Using direct base64 encoding');
                $imageData = file_get_contents($imagePath);
                $mimeType = mime_content_type($imagePath);
                $base64 = 'data:' . $mimeType . ';base64,' . base64_encode($imageData);
                \Log::info('✅ Direct base64 SUCCESS', [
                    'size_kb' => round($fileSize / 1024, 2),
                    'base64_length' => strlen($base64)
                ]);
                return $base64;
            }
            
            \Log::error('❌ Image too large even for direct encoding', ['size_kb' => round($fileSize / 1024, 2)]);
            
        } catch (\Exception $e) {
            \Log::error('❌ EXCEPTION in email thumbnail', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
        
        // Last fallback
        \Log::warning('⚠️ Using Unsplash fallback');
        return 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=800&q=80';
    }
    
    /**
     * Compress image for email using GD library
     * Returns base64 encoded compressed image or null on failure
     */
    private function getCompressedImageBase64(string $imagePath): ?string
    {
        try {
            $extension = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));
            
            // Load image based on type
            switch ($extension) {
                case 'jpg':
                case 'jpeg':
                    $source = @imagecreatefromjpeg($imagePath);
                    break;
                case 'png':
                    $source = @imagecreatefrompng($imagePath);
                    break;
                case 'gif':
                    $source = @imagecreatefromgif($imagePath);
                    break;
                default:
                    \Log::warning('Unsupported image format for compression', ['extension' => $extension]);
                    return null;
            }
            
            if (!$source) {
                \Log::error('Failed to load image for compression', ['path' => $imagePath]);
                return null;
            }
            
            // Get original dimensions
            $originalWidth = imagesx($source);
            $originalHeight = imagesy($source);
            
            // Calculate new dimensions (max 800px width for email)
            $maxWidth = 800;
            if ($originalWidth > $maxWidth) {
                $ratio = $maxWidth / $originalWidth;
                $newWidth = $maxWidth;
                $newHeight = (int)($originalHeight * $ratio);
            } else {
                $newWidth = $originalWidth;
                $newHeight = $originalHeight;
            }
            
            // Create new image
            $resized = imagecreatetruecolor($newWidth, $newHeight);
            
            // Preserve transparency for PNG/GIF
            if ($extension === 'png' || $extension === 'gif') {
                imagealphablending($resized, false);
                imagesavealpha($resized, true);
                $transparent = imagecolorallocatealpha($resized, 255, 255, 255, 127);
                imagefilledrectangle($resized, 0, 0, $newWidth, $newHeight, $transparent);
            }
            
            // Resize
            imagecopyresampled($resized, $source, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);
            
            // Capture output
            ob_start();
            
            // Output with compression
            switch ($extension) {
                case 'jpg':
                case 'jpeg':
                    imagejpeg($resized, null, 75); // 75% quality
                    $mimeType = 'image/jpeg';
                    break;
                case 'png':
                    imagepng($resized, null, 7); // compression level 7
                    $mimeType = 'image/png';
                    break;
                case 'gif':
                    imagegif($resized, null);
                    $mimeType = 'image/gif';
                    break;
            }
            
            $imageData = ob_get_clean();
            
            // Free memory
            imagedestroy($source);
            imagedestroy($resized);
            
            // Log compression result
            $compressedSize = strlen($imageData);
            \Log::info('Image compressed', [
                'original_dimensions' => "{$originalWidth}x{$originalHeight}",
                'new_dimensions' => "{$newWidth}x{$newHeight}",
                'compressed_size_kb' => round($compressedSize / 1024, 2),
            ]);
            
            return 'data:' . $mimeType . ';base64,' . base64_encode($imageData);
            
        } catch (\Exception $e) {
            \Log::error('Image compression failed: ' . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Get the local room image file path for email attachments
     * Returns full file system path or null if not found
     */
    public function getLocalRoomImagePath(): ?string
    {
        $filename = $this->getLocalRoomImageFilename();
        if (!$filename) {
            return null;
        }
        
        $fullPath = public_path('images/rooms/' . $filename);
        return file_exists($fullPath) ? $fullPath : null;
    }

    /**
     * Get absolute thumbnail URL for emails (legacy - use email_thumbnail_url instead)
     * @deprecated Use email_thumbnail_url for better email compatibility
     */
    public function getAbsoluteThumbnailUrlAttribute(): string
    {
        return $this->email_thumbnail_url;
    }

    public function getFormattedPriceAttribute(): string
    {
        return '₱' . number_format($this->price_per_night, 2);
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
