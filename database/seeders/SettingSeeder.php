<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'hotel_name',        'value' => 'Monarch Hotel',                                  'group' => 'general'],
            ['key' => 'hotel_tagline',     'value' => 'Where Luxury Meets Comfort',                     'group' => 'general'],
            ['key' => 'hotel_email',       'value' => 'info@monarchhotel.com',                          'group' => 'general'],
            ['key' => 'hotel_phone',       'value' => '+63 (75) 123-4567',                              'group' => 'general'],
            ['key' => 'hotel_phone2',      'value' => '+63 912 345 6789',                               'group' => 'general'],
            ['key' => 'hotel_address',     'value' => 'National Highway, Calasiao, Pangasinan 2418',    'group' => 'general'],
            ['key' => 'hotel_description', 'value' => 'Monarch Hotel is a premier luxury hotel in Calasiao, Pangasinan, Philippines. We offer world-class accommodations, fine dining, and exceptional service.',  'group' => 'general'],
            ['key' => 'check_in_time',     'value' => '2:00 PM',                                        'group' => 'policy'],
            ['key' => 'check_out_time',    'value' => '12:00 PM',                                       'group' => 'policy'],
            ['key' => 'tax_rate',          'value' => '12',                                             'group' => 'billing'],
            ['key' => 'facebook_url',      'value' => 'https://facebook.com/subohotel',              'group' => 'social'],
            ['key' => 'instagram_url',     'value' => 'https://instagram.com/subohotel',             'group' => 'social'],
            ['key' => 'twitter_url',       'value' => 'https://twitter.com/subohotel',              'group' => 'social'],
            ['key' => 'google_map_embed',  'value' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3831.5!2d120.3641!3d16.0069!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTbCsDAwJzI0LjgiTiAxMjDCsDIxJzUwLjgiRQ!5e0!3m2!1sen!2sph!4v1620000000000!5m2!1sen!2sph', 'group' => 'general'],
            ['key' => 'business_hours',    'value' => 'Mon-Sun: 24 Hours',                             'group' => 'general'],
        ];

        foreach ($settings as $setting) {
            Setting::firstOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
