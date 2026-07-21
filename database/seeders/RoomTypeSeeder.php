<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoomType;

class RoomTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Deluxe Room',         'slug' => 'deluxe-room',         'description' => 'Comfortable and elegantly furnished with modern amenities.',           'icon' => 'bi-door-open'],
            ['name' => 'Superior Room',        'slug' => 'superior-room',       'description' => 'A step above standard, offering more space and premium furnishings.',   'icon' => 'bi-star'],
            ['name' => 'Premier Room',         'slug' => 'premier-room',        'description' => 'Premium room with exceptional views and luxury fittings.',              'icon' => 'bi-star-fill'],
            ['name' => 'Executive Suite',      'slug' => 'executive-suite',     'description' => 'Spacious suite with separate living area, ideal for business travelers.','icon' => 'bi-briefcase'],
            ['name' => 'Family Suite',         'slug' => 'family-suite',        'description' => 'Designed for families, with multiple sleeping areas and extra space.',   'icon' => 'bi-people'],
            ['name' => 'Presidential Suite',   'slug' => 'presidential-suite',  'description' => 'The pinnacle of luxury — our most exclusive accommodation.',            'icon' => 'bi-gem'],
        ];

        foreach ($types as $type) {
            RoomType::firstOrCreate(['slug' => $type['slug']], array_merge($type, ['is_active' => true]));
        }
    }
}
