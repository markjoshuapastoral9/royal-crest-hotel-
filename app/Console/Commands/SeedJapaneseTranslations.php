<?php

namespace App\Console\Commands;

use App\Models\Promotion;
use App\Models\Testimonial;
use Illuminate\Console\Command;

class SeedJapaneseTranslations extends Command
{
    protected $signature = 'translations:seed-ja-placeholders';
    protected $description = 'Add Japanese translation placeholders to promotions and testimonials';

    public function handle()
    {
        $this->info('Adding Japanese translation placeholders...');

        // Promotions
        $promotions = Promotion::all();
        foreach ($promotions as $promo) {
            $promo->update([
                'title_translations' => array_merge($promo->title_translations ?? [], [
                    'ja' => '[日本語翻訳が必要: ' . $promo->title . ']'
                ]),
                'description_translations' => array_merge($promo->description_translations ?? [], [
                    'ja' => '[日本語翻訳が必要: ' . $promo->description . ']'
                ]),
            ]);
        }
        $this->info("✓ Updated {$promotions->count()} promotions");

        // Testimonials
        $testimonials = Testimonial::all();
        foreach ($testimonials as $test) {
            $test->update([
                'content_translations' => array_merge($test->content_translations ?? [], [
                    'ja' => '[日本語翻訳が必要: ' . $test->content . ']'
                ]),
                'guest_name_translations' => array_merge($test->guest_name_translations ?? [], [
                    'ja' => $test->guest_name // Keep names as-is
                ]),
                'guest_location_translations' => array_merge($test->guest_location_translations ?? [], [
                    'ja' => $test->guest_location // Keep locations as-is
                ]),
            ]);
        }
        $this->info("✓ Updated {$testimonials->count()} testimonials");

        $this->info('Done! Switch to Japanese (ja) to see placeholders.');
        return 0;
    }
}
