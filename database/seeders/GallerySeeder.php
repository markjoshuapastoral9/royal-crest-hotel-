<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gallery;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            // Hotel
            ['category' => 'hotel',      'title' => 'Hotel Lobby',        'image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800&q=80', 'is_featured' => true],
            ['category' => 'hotel',      'title' => 'Hotel Exterior',     'image' => 'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=800&q=80', 'is_featured' => true],
            ['category' => 'hotel',      'title' => 'Hotel Lounge',       'image' => 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=800&q=80', 'is_featured' => false],
            ['category' => 'hotel',      'title' => 'Reception Area',     'image' => 'https://images.unsplash.com/photo-1590490359854-dfb89b1b8e7a?w=800&q=80', 'is_featured' => false],
            // Rooms
            ['category' => 'rooms',      'title' => 'Deluxe Room',        'image' => 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=800&q=80', 'is_featured' => true],
            ['category' => 'rooms',      'title' => 'Executive Suite',    'image' => 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?w=800&q=80', 'is_featured' => true],
            ['category' => 'rooms',      'title' => 'Presidential Suite', 'image' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=800&q=80', 'is_featured' => false],
            ['category' => 'rooms',      'title' => 'Bathroom',           'image' => 'https://images.unsplash.com/photo-1552321554-5fefe8c9ef14?w=800&q=80', 'is_featured' => false],
            // Facilities
            ['category' => 'facilities', 'title' => 'Swimming Pool',      'image' => 'https://images.unsplash.com/photo-1564501049412-61c2a3083791?w=800&q=80', 'is_featured' => true],
            ['category' => 'facilities', 'title' => 'Fitness Center',     'image' => 'https://images.unsplash.com/photo-1540497077202-7c8a3999166f?w=800&q=80', 'is_featured' => false],
            ['category' => 'facilities', 'title' => 'Spa',                'image' => 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=800&q=80', 'is_featured' => false],
            // Restaurant
            ['category' => 'restaurant', 'title' => 'Fine Dining',        'image' => 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=800&q=80', 'is_featured' => true],
            ['category' => 'restaurant', 'title' => 'Breakfast Buffet',   'image' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=800&q=80', 'is_featured' => false],
            ['category' => 'restaurant', 'title' => 'Bar & Lounge',       'image' => 'https://images.unsplash.com/photo-1510626176961-4b57d4fbad03?w=800&q=80', 'is_featured' => false],
            // Pool
            ['category' => 'pool',       'title' => 'Pool Daytime',       'image' => 'https://images.unsplash.com/photo-1576013551627-0cc20b96c2a7?w=800&q=80', 'is_featured' => true],
            ['category' => 'pool',       'title' => 'Pool at Night',      'image' => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=800&q=80', 'is_featured' => false],
            // Events
            ['category' => 'events',     'title' => 'Wedding Venue',      'image' => 'https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=800&q=80', 'is_featured' => true],
            ['category' => 'events',     'title' => 'Conference Hall',    'image' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?w=800&q=80', 'is_featured' => false],
        ];

        foreach ($items as $i => $item) {
            Gallery::firstOrCreate(
                ['image' => $item['image']],
                array_merge($item, ['sort_order' => $i])
            );
        }
    }
}
