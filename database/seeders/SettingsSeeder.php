<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'hotel_name',        'value' => 'Monarch Hotel',                          'group' => 'general'],
            ['key' => 'hotel_tagline',     'value' => 'Where Luxury Meets Comfort',             'group' => 'general'],
            ['key' => 'hotel_email',       'value' => 'info@monarchhotel.com',                  'group' => 'general'],
            ['key' => 'hotel_phone',       'value' => '+63 75 123 4567',                        'group' => 'general'],
            ['key' => 'hotel_address',     'value' => 'Calasiao, Pangasinan, Philippines 2418', 'group' => 'general'],
            ['key' => 'hotel_description', 'value' => 'Monarch Hotel offers world-class accommodations in the heart of Calasiao, Pangasinan. Experience luxury, comfort, and impeccable Filipino hospitality.', 'group' => 'general'],
            ['key' => 'check_in_time',     'value' => '2:00 PM',                                'group' => 'policy'],
            ['key' => 'check_out_time',    'value' => '12:00 PM',                               'group' => 'policy'],
            ['key' => 'tax_rate',          'value' => '12',                                     'group' => 'policy'],
            ['key' => 'currency',          'value' => '₱',                                      'group' => 'general'],
            ['key' => 'facebook_url',      'value' => 'https://facebook.com/royalcresthotel',      'group' => 'social'],
            ['key' => 'instagram_url',     'value' => 'https://instagram.com/royalcresthotel',     'group' => 'social'],
            ['key' => 'twitter_url',       'value' => 'https://twitter.com/royalcresthotel',       'group' => 'social'],
            ['key' => 'google_maps_url',   'value' => 'https://maps.google.com/?q=Calasiao+Pangasinan', 'group' => 'general'],
        ];

        foreach ($settings as $setting) {
            Setting::firstOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
