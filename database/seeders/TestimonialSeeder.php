<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimonial;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            ['guest_name' => 'Maria Santos',     'guest_location' => 'Manila, Philippines',    'rating' => 5, 'content' => 'Absolutely stunning hotel! The Presidential Suite exceeded all our expectations. The staff was incredibly attentive and the food at the restaurant was world-class. We will definitely return!', 'is_featured' => true],
            ['guest_name' => 'James Wilson',     'guest_location' => 'Singapore',              'rating' => 5, 'content' => 'Monarch Hotel is a hidden gem in Pangasinan. The swimming pool area is beautiful, the rooms are spotless, and the service is impeccable. Perfect for a romantic getaway.', 'is_featured' => true],
            ['guest_name' => 'Ana Reyes',        'guest_location' => 'Cebu City, Philippines', 'rating' => 5, 'content' => 'We hosted our wedding reception here and it was magical. The event team went above and beyond to make our special day perfect. The ballroom looked absolutely gorgeous!', 'is_featured' => true],
            ['guest_name' => 'David Chen',       'guest_location' => 'Hong Kong',              'rating' => 4, 'content' => 'Great business hotel. The conference facilities are modern and well-equipped. The executive suite was comfortable and the breakfast selection was impressive. Good value for money.', 'is_featured' => true],
            ['guest_name' => 'Grace Villanueva', 'guest_location' => 'Dagupan City, PH',       'rating' => 5, 'content' => 'The spa experience was divine! The therapists are highly skilled and the ambiance is incredibly relaxing. The family suite was perfect for our whole family. Highly recommended!', 'is_featured' => true],
            ['guest_name' => 'Robert Kim',       'guest_location' => 'South Korea',            'rating' => 4, 'content' => 'Very comfortable stay. Clean rooms, friendly staff, and excellent facilities. The location is convenient and the food is delicious. Will definitely book again on my next Philippines trip.', 'is_featured' => true],
        ];

        foreach ($testimonials as $t) {
            Testimonial::firstOrCreate(['guest_name' => $t['guest_name']], array_merge($t, ['is_active' => true]));
        }
    }
}
