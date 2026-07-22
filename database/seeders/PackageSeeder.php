<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            [
                'name' => 'Romantic Getaway Package',
                'slug' => 'romantic-getaway',
                'description' => 'Perfect for couples seeking a romantic escape. Includes accommodation, dining, and a relaxing spa experience for two.',
                'price' => 15999.00,
                'original_price' => 20000.00,
                'min_nights' => 2,
                'inclusions' => ['room', 'breakfast', 'dinner', 'spa', 'welcome_drink', 'late_checkout'],
                'image' => 'images/packages/romantic-getaway.jpg',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 1,
                'valid_from' => now(),
                'valid_until' => now()->addYear(),
            ],
            [
                'name' => 'Family Fun Package',
                'slug' => 'family-fun',
                'description' => 'Create lasting memories with your loved ones. Includes family room, meals, and access to all hotel facilities.',
                'price' => 12999.00,
                'original_price' => 16000.00,
                'min_nights' => 3,
                'inclusions' => ['room', 'breakfast', 'lunch', 'wifi', 'welcome_drink'],
                'image' => 'images/packages/family-fun.jpg',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 2,
                'valid_from' => now(),
                'valid_until' => now()->addYear(),
            ],
            [
                'name' => 'Wellness Retreat Package',
                'slug' => 'wellness-retreat',
                'description' => 'Rejuvenate your mind, body, and soul. Includes spa treatments, healthy meals, and yoga sessions.',
                'price' => 18999.00,
                'original_price' => 24000.00,
                'min_nights' => 3,
                'inclusions' => ['room', 'breakfast', 'lunch', 'dinner', 'spa', 'massage', 'wifi'],
                'image' => 'images/packages/wellness-retreat.jpg',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 3,
                'valid_from' => now(),
                'valid_until' => now()->addYear(),
            ],
            [
                'name' => 'Business Traveler Package',
                'slug' => 'business-traveler',
                'description' => 'Everything you need for a productive stay. High-speed WiFi, meeting room access, and executive breakfast.',
                'price' => 8999.00,
                'original_price' => 11000.00,
                'min_nights' => 1,
                'inclusions' => ['room', 'breakfast', 'wifi', 'late_checkout'],
                'image' => 'images/packages/business-traveler.jpg',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 4,
                'valid_from' => now(),
                'valid_until' => now()->addYear(),
            ],
            [
                'name' => 'Staycation Delight',
                'slug' => 'staycation-delight',
                'description' => 'Escape the ordinary without going far. Enjoy a relaxing staycation with full board meals and spa access.',
                'price' => 10999.00,
                'original_price' => 14000.00,
                'min_nights' => 2,
                'inclusions' => ['room', 'breakfast', 'lunch', 'dinner', 'spa', 'wifi'],
                'image' => 'images/packages/staycation.jpg',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 5,
                'valid_from' => now(),
                'valid_until' => now()->addYear(),
            ],
            [
                'name' => 'Honeymoon Bliss Package',
                'slug' => 'honeymoon-bliss',
                'description' => 'Start your journey together in paradise. Luxurious honeymoon suite, couples spa, romantic dinner, and more.',
                'price' => 22999.00,
                'original_price' => 30000.00,
                'min_nights' => 3,
                'inclusions' => ['room', 'breakfast', 'dinner', 'spa', 'massage', 'welcome_drink', 'late_checkout', 'airport_transfer'],
                'image' => 'images/packages/honeymoon.jpg',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 0,
                'valid_from' => now(),
                'valid_until' => now()->addYear(),
            ],
        ];

        foreach ($packages as $package) {
            Package::create($package);
        }
    }
}
