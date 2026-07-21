<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Amenity;

class AmenitySeeder extends Seeder
{
    public function run(): void
    {
        $amenities = [
            // Room amenities
            ['name' => 'Free WiFi',          'icon' => 'bi-wifi',              'category' => 'room'],
            ['name' => 'Air Conditioning',   'icon' => 'bi-thermometer-snow',  'category' => 'room'],
            ['name' => 'Flat-screen TV',     'icon' => 'bi-tv',                'category' => 'room'],
            ['name' => 'Mini Bar',           'icon' => 'bi-cup-straw',         'category' => 'room'],
            ['name' => 'Breakfast Included', 'icon' => 'bi-egg-fried',         'category' => 'room'],
            ['name' => 'Room Service',       'icon' => 'bi-bell',              'category' => 'room'],
            ['name' => 'Private Bathroom',   'icon' => 'bi-droplet',           'category' => 'room'],
            ['name' => 'Safe Box',           'icon' => 'bi-lock',              'category' => 'room'],
            ['name' => 'Bathtub',            'icon' => 'bi-water',             'category' => 'room'],
            ['name' => 'Balcony',            'icon' => 'bi-house-door',        'category' => 'room'],
            ['name' => 'Work Desk',          'icon' => 'bi-laptop',            'category' => 'room'],
            ['name' => 'King Bed',           'icon' => 'bi-moon',              'category' => 'room'],
            // Hotel amenities
            ['name' => 'Swimming Pool',      'icon' => 'bi-water',             'category' => 'hotel'],
            ['name' => 'Fitness Center',     'icon' => 'bi-heart-pulse',       'category' => 'hotel'],
            ['name' => 'Spa & Wellness',     'icon' => 'bi-flower1',           'category' => 'hotel'],
            ['name' => 'Restaurant',         'icon' => 'bi-cup-hot',           'category' => 'hotel'],
            ['name' => 'Free Parking',       'icon' => 'bi-p-circle',          'category' => 'hotel'],
            ['name' => 'Airport Shuttle',    'icon' => 'bi-bus-front',         'category' => 'hotel'],
            ['name' => 'Conference Hall',    'icon' => 'bi-building',          'category' => 'hotel'],
            ['name' => 'Wedding Venue',      'icon' => 'bi-heart',             'category' => 'hotel'],
        ];

        foreach ($amenities as $amenity) {
            Amenity::firstOrCreate(['name' => $amenity['name']], array_merge($amenity, ['is_active' => true]));
        }
    }
}
