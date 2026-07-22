<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PromoSeeder extends Seeder
{
    public function run(): void
    {
        $promos = [
            // Existing promos
            ['title' => 'Welcome Discount',   'code' => 'WELCOME10',   'discount_type' => 'percentage', 'discount_value' => 10,   'minimum_nights' => 1, 'usage_limit' => null, 'valid_until' => now()->addYear()->toDateString(),     'description' => 'Get 10% off your first booking.'],
            ['title' => 'Summer Sale 20%',     'code' => 'SUMMER20',    'discount_type' => 'percentage', 'discount_value' => 20,   'minimum_nights' => 2, 'usage_limit' => 50,   'valid_until' => now()->addMonths(3)->toDateString(),  'description' => '20% off for 2 nights or more.'],
            ['title' => 'Long Stay ₱500 Off',  'code' => 'STAY500',     'discount_type' => 'fixed',      'discount_value' => 500,  'minimum_nights' => 3, 'usage_limit' => 100,  'valid_until' => now()->addMonths(6)->toDateString(),  'description' => 'Flat ₱500 off for 3 nights or more.'],
            ['title' => 'Weekend Getaway',     'code' => 'WEEKEND15',   'discount_type' => 'percentage', 'discount_value' => 15,   'minimum_nights' => 1, 'usage_limit' => null, 'valid_until' => now()->addMonths(2)->toDateString(),  'description' => '15% off weekend stays.'],
            ['title' => 'Loyalty Reward',      'code' => 'LOYAL25',     'discount_type' => 'percentage', 'discount_value' => 25,   'minimum_nights' => 2, 'usage_limit' => 20,   'valid_until' => now()->addYear()->toDateString(),     'description' => '25% off for loyal guests.'],
            // New promos
            ['title' => 'First Booking Discount', 'code' => 'ROYAL5',    'discount_type' => 'percentage', 'discount_value' => 5,    'minimum_nights' => 1, 'usage_limit' => null, 'valid_until' => now()->addYear()->toDateString(),     'description' => 'Small discount for everyone.'],
            ['title' => 'New Guest Special',   'code' => 'NEWGUEST30',  'discount_type' => 'percentage', 'discount_value' => 30,   'minimum_nights' => 1, 'usage_limit' => 10,   'valid_until' => now()->addMonths(6)->toDateString(),  'description' => 'New guest special offer — limited slots.'],
            ['title' => 'Honeymoon Package',   'code' => 'HONEYMOON20', 'discount_type' => 'percentage', 'discount_value' => 20,   'minimum_nights' => 3, 'usage_limit' => 15,   'valid_until' => now()->addYear()->toDateString(),     'description' => 'Honeymoon package deal, minimum 3 nights.'],
            ['title' => 'Family Stay',         'code' => 'FAMILY15',    'discount_type' => 'percentage', 'discount_value' => 15,   'minimum_nights' => 2, 'usage_limit' => null, 'valid_until' => now()->addYear()->toDateString(),     'description' => 'Family stay discount.'],
            ['title' => 'Birthday Treat',      'code' => 'BDAY50',      'discount_type' => 'fixed',      'discount_value' => 50,   'minimum_nights' => 1, 'usage_limit' => null, 'valid_until' => now()->addYear()->toDateString(),     'description' => '₱50 off as a birthday treat.'],
            ['title' => 'Flash Sale',          'code' => 'FLASH40',     'discount_type' => 'percentage', 'discount_value' => 40,   'minimum_nights' => 1, 'usage_limit' => 5,    'valid_until' => now()->addMonths(1)->toDateString(),  'description' => 'Flash sale — only 5 slots available!'],
            ['title' => 'Student Discount',    'code' => 'STUDENT10',   'discount_type' => 'percentage', 'discount_value' => 10,   'minimum_nights' => 1, 'usage_limit' => null, 'valid_until' => now()->addYear()->toDateString(),     'description' => 'Student discount.'],
            ['title' => 'Senior Citizen',      'code' => 'SENIOR20',    'discount_type' => 'percentage', 'discount_value' => 20,   'minimum_nights' => 1, 'usage_limit' => null, 'valid_until' => now()->addYear()->toDateString(),     'description' => 'Senior citizen discount.'],
            ['title' => 'Extended Stay ₱1000', 'code' => 'LONGSTAY1K',  'discount_type' => 'fixed',      'discount_value' => 1000, 'minimum_nights' => 5, 'usage_limit' => 30,   'valid_until' => now()->addYear()->toDateString(),     'description' => '₱1000 off for 5-night extended stays.'],
            ['title' => 'VIP Exclusive',       'code' => 'VIP35',       'discount_type' => 'percentage', 'discount_value' => 35,   'minimum_nights' => 2, 'usage_limit' => 10,   'valid_until' => now()->addYear()->toDateString(),     'description' => 'VIP exclusive offer.'],
            ['title' => 'Early Bird',          'code' => 'EARLYBIRD25', 'discount_type' => 'percentage', 'discount_value' => 25,   'minimum_nights' => 2, 'usage_limit' => 50,   'valid_until' => now()->addYear()->toDateString(),     'description' => 'Book 30 days in advance and save 25%.'],
            ['title' => 'Last Minute Deal',    'code' => 'LASTMIN15',   'discount_type' => 'percentage', 'discount_value' => 15,   'minimum_nights' => 1, 'usage_limit' => null, 'valid_until' => now()->addMonths(3)->toDateString(),  'description' => 'Last minute booking discount.'],
            ['title' => 'Anniversary Special', 'code' => 'ANNIVERSARY', 'discount_type' => 'fixed',      'discount_value' => 750,  'minimum_nights' => 3, 'usage_limit' => 10,   'valid_until' => now()->addYear()->toDateString(),     'description' => '₱750 off for anniversary celebrations.'],
            ['title' => 'Rainy Season Deal',   'code' => 'RAINY20',     'discount_type' => 'percentage', 'discount_value' => 20,   'minimum_nights' => 1, 'usage_limit' => null, 'valid_until' => now()->addMonths(4)->toDateString(),  'description' => 'Rainy season special discount.'],
            ['title' => 'Holiday Season',      'code' => 'DECEMBER10',  'discount_type' => 'percentage', 'discount_value' => 10,   'minimum_nights' => 1, 'usage_limit' => null, 'valid_until' => now()->addYear()->toDateString(),     'description' => 'Holiday season discount.'],
            ['title' => 'Holiday Package',     'code' => 'HOLIDAY15',   'discount_type' => 'percentage', 'discount_value' => 15,   'minimum_nights' => 2, 'usage_limit' => null, 'valid_until' => now()->addYear()->toDateString(),     'description' => 'Holiday package deal.'],
            ['title' => 'New Year Special',    'code' => 'NEWYEAR500',  'discount_type' => 'fixed',      'discount_value' => 500,  'minimum_nights' => 2, 'usage_limit' => 20,   'valid_until' => now()->addMonths(6)->toDateString(),  'description' => '₱500 off New Year special.'],
            ['title' => 'Complimentary',       'code' => 'FREESHIP',    'discount_type' => 'fixed',      'discount_value' => 200,  'minimum_nights' => 1, 'usage_limit' => null, 'valid_until' => now()->addYear()->toDateString(),     'description' => '₱200 complimentary discount.'],
            ['title' => 'Payday Deal',         'code' => 'PAYDAY20',    'discount_type' => 'percentage', 'discount_value' => 20,   'minimum_nights' => 1, 'usage_limit' => 100,  'valid_until' => now()->addYear()->toDateString(),     'description' => 'Mid/end of month payday deal.'],
            ['title' => 'Referral Reward',     'code' => 'REFERRAL10',  'discount_type' => 'percentage', 'discount_value' => 10,   'minimum_nights' => 1, 'usage_limit' => null, 'valid_until' => now()->addYear()->toDateString(),     'description' => 'Referral reward — share and save!'],
        ];

        $count = 0;
        foreach ($promos as $promo) {
            \DB::table('promotions')->updateOrInsert(
                ['code' => $promo['code']],
                array_merge($promo, [
                    'minimum_amount' => 0,
                    'valid_from'     => now()->toDateString(),
                    'used_count'     => 0,
                    'is_active'      => true,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ])
            );
            $count++;
            echo "  ✅ {$promo['code']} — {$promo['title']}\n";
        }

        echo "\n🎉 Total: {$count} promo codes ready!\n";
    }
}
