<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Facility;

class FacilitySeeder extends Seeder
{
    public function run(): void
    {
        $facilities = [
            [
                'name'            => 'Swimming Pool',
                'slug'            => 'swimming-pool',
                'description'     => 'Dive into our stunning outdoor swimming pool surrounded by lush tropical gardens. Available to all guests with dedicated lanes and a shallow wading area for children.',
                'icon'            => 'bi-water',
                'operating_hours' => '6:00 AM – 10:00 PM',
                'is_featured'     => true,
                'sort_order'      => 1,
            ],
            [
                'name'            => 'Restaurant & Dining',
                'slug'            => 'restaurant',
                'description'     => 'The Royal Crest signature restaurant serves an exquisite array of Filipino and international cuisine. From hearty breakfast buffets to intimate candlelit dinners, our culinary team crafts every dish with passion.',
                'icon'            => 'bi-cup-hot',
                'operating_hours' => '6:00 AM – 10:30 PM',
                'is_featured'     => true,
                'sort_order'      => 2,
            ],
            [
                'name'            => 'Fitness Center',
                'slug'            => 'fitness-center',
                'description'     => 'Maintain your wellness routine with state-of-the-art equipment. Our gym features cardio machines, free weights, and dedicated zones for yoga and stretching.',
                'icon'            => 'bi-heart-pulse',
                'operating_hours' => '5:00 AM – 11:00 PM',
                'is_featured'     => true,
                'sort_order'      => 3,
            ],
            [
                'name'            => 'Spa & Wellness',
                'slug'            => 'spa',
                'description'     => 'Surrender to tranquility at Royal Crest Spa. Our expert therapists offer a curated menu of massages, body treatments, and facials using locally sourced, natural ingredients.',
                'icon'            => 'bi-flower1',
                'operating_hours' => '9:00 AM – 9:00 PM',
                'is_featured'     => true,
                'sort_order'      => 4,
            ],
            [
                'name'            => 'Conference Hall',
                'slug'            => 'conference-hall',
                'description'     => 'Host impactful events in our fully equipped conference hall. With a capacity of up to 500 guests, state-of-the-art AV systems, and dedicated event coordinators.',
                'icon'            => 'bi-building',
                'operating_hours' => 'By appointment',
                'is_featured'     => true,
                'sort_order'      => 5,
            ],
            [
                'name'            => 'Wedding Venue',
                'slug'            => 'wedding-venue',
                'description'     => 'Create the wedding of your dreams at Monarch Hotel. Our stunning grand ballroom and garden venues provide the perfect backdrop for your most special day.',
                'icon'            => 'bi-heart',
                'operating_hours' => 'By appointment',
                'is_featured'     => true,
                'sort_order'      => 6,
            ],
            [
                'name'            => 'Free Parking',
                'slug'            => 'parking',
                'description'     => 'Complimentary secured parking for all in-house guests. Valet parking service is also available upon request.',
                'icon'            => 'bi-p-circle',
                'operating_hours' => '24 hours',
                'is_featured'     => false,
                'sort_order'      => 7,
            ],
            [
                'name'            => 'Airport Shuttle',
                'slug'            => 'airport-shuttle',
                'description'     => 'Convenient airport transfer service available to and from NAIA and Clark International Airport. Pre-booking required.',
                'icon'            => 'bi-bus-front',
                'operating_hours' => 'By schedule',
                'is_featured'     => false,
                'sort_order'      => 8,
            ],
        ];

        foreach ($facilities as $facility) {
            Facility::firstOrCreate(['slug' => $facility['slug']], array_merge($facility, ['is_active' => true]));
        }
    }
}
