<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Update facilities
DB::table('facilities')->where('slug', 'restaurant')->update([
    'description' => "The Royal Crest signature restaurant serves an exquisite array of Filipino and international cuisine. From hearty breakfast buffets to intimate candlelit dinners, our culinary team crafts every dish with passion."
]);

DB::table('facilities')->where('slug', 'spa')->update([
    'description' => "Surrender to tranquility at Royal Crest Spa. Our expert therapists offer a curated menu of massages, body treatments, and facials using locally sourced, natural ingredients."
]);

DB::table('facilities')->where('slug', 'wedding-venue')->update([
    'description' => "Create the wedding of your dreams at Royal Crest Hotel. Our stunning grand ballroom and garden venues provide the perfect backdrop for your most special day."
]);

// Update rooms with Monarch references
DB::table('rooms')->where('description', 'like', '%Monarch Hotel%')->update([
    'description' => DB::raw("REPLACE(description, 'Monarch Hotel', 'Royal Crest Hotel')")
]);

// Update promotions
DB::table('promotions')->where('description', 'like', '%Monarch Hotel%')->update([
    'description' => DB::raw("REPLACE(description, 'Monarch Hotel', 'Royal Crest Hotel')")
]);

// Update settings - social media
DB::table('settings')->where('key', 'facebook_url')->update(['value' => 'https://facebook.com/royalcresthotel']);
DB::table('settings')->where('key', 'instagram_url')->update(['value' => 'https://instagram.com/royalcresthotel']);
DB::table('settings')->where('key', 'twitter_url')->update(['value' => 'https://twitter.com/royalcresthotel']);

echo "✅ Database updated successfully!\n";
echo "All 'Monarch' references have been replaced with 'Royal Crest'\n";
