<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SettingsSeeder::class,
            RolePermissionSeeder::class,
            UserSeeder::class,
            AmenitySeeder::class,
            RoomTypeSeeder::class,
            RoomSeeder::class,
            FacilitySeeder::class,
            PromotionSeeder::class,
            TestimonialSeeder::class,
            GallerySeeder::class,
            BookingSeeder::class,
        ]);
    }
}
