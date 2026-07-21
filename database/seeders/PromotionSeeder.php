<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Promotion;
use Carbon\Carbon;

class PromotionSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::today();

        $promos = [
            // Existing
            ['code'=>'WELCOME10',   'title'=>'Welcome Discount',        'type'=>'percentage','value'=>10,   'nights'=>1,'limit'=>null,'months'=>12],
            ['code'=>'SUMMER20',    'title'=>'Summer Sale',              'type'=>'percentage','value'=>20,   'nights'=>2,'limit'=>50,  'months'=>3],
            ['code'=>'STAY500',     'title'=>'Stay & Save',              'type'=>'fixed',     'value'=>500,  'nights'=>3,'limit'=>100, 'months'=>6],
            ['code'=>'WEEKEND15',   'title'=>'Weekend Special',          'type'=>'percentage','value'=>15,   'nights'=>1,'limit'=>null,'months'=>2],
            ['code'=>'LOYAL25',     'title'=>'Loyal Guest Reward',       'type'=>'percentage','value'=>25,   'nights'=>2,'limit'=>20,  'months'=>12],
            // New
            ['code'=>'BDAY2026',    'title'=>'Birthday Promo 2026',      'type'=>'percentage','value'=>50,   'nights'=>1,'limit'=>100, 'months'=>12],
            ['code'=>'MONARCH5',    'title'=>'Monarch Promo',            'type'=>'percentage','value'=>5,    'nights'=>1,'limit'=>null,'months'=>12],
            ['code'=>'NEWGUEST30',  'title'=>'New Guest Offer',          'type'=>'percentage','value'=>30,   'nights'=>1,'limit'=>10,  'months'=>6],
            ['code'=>'HONEYMOON20', 'title'=>'Honeymoon Package',        'type'=>'percentage','value'=>20,   'nights'=>3,'limit'=>15,  'months'=>12],
            ['code'=>'FAMILY15',    'title'=>'Family Stay',              'type'=>'percentage','value'=>15,   'nights'=>2,'limit'=>null,'months'=>12],
            ['code'=>'BDAY50',      'title'=>'Birthday Treat',           'type'=>'fixed',     'value'=>50,   'nights'=>1,'limit'=>null,'months'=>12],
            ['code'=>'FLASH40',     'title'=>'Flash Sale',               'type'=>'percentage','value'=>40,   'nights'=>1,'limit'=>5,   'months'=>3],
            ['code'=>'STUDENT10',   'title'=>'Student Discount',         'type'=>'percentage','value'=>10,   'nights'=>1,'limit'=>null,'months'=>12],
            ['code'=>'SENIOR20',    'title'=>'Senior Citizen Discount',  'type'=>'percentage','value'=>20,   'nights'=>1,'limit'=>null,'months'=>12],
            ['code'=>'LONGSTAY1K',  'title'=>'Long Stay Reward',         'type'=>'fixed',     'value'=>1000, 'nights'=>5,'limit'=>30,  'months'=>12],
            ['code'=>'VIP35',       'title'=>'VIP Exclusive',            'type'=>'percentage','value'=>35,   'nights'=>2,'limit'=>10,  'months'=>12],
            ['code'=>'EARLYBIRD25', 'title'=>'Early Bird',               'type'=>'percentage','value'=>25,   'nights'=>2,'limit'=>50,  'months'=>12],
            ['code'=>'LASTMIN15',   'title'=>'Last Minute Deal',         'type'=>'percentage','value'=>15,   'nights'=>1,'limit'=>null,'months'=>6],
            ['code'=>'ANNIVERSARY', 'title'=>'Anniversary Special',      'type'=>'fixed',     'value'=>750,  'nights'=>3,'limit'=>10,  'months'=>12],
            ['code'=>'RAINY20',     'title'=>'Rainy Season Promo',       'type'=>'percentage','value'=>20,   'nights'=>1,'limit'=>null,'months'=>6],
            ['code'=>'DECEMBER10',  'title'=>'December Holiday',         'type'=>'percentage','value'=>10,   'nights'=>1,'limit'=>null,'months'=>12],
            ['code'=>'HOLIDAY15',   'title'=>'Holiday Package',          'type'=>'percentage','value'=>15,   'nights'=>2,'limit'=>null,'months'=>12],
            ['code'=>'NEWYEAR500',  'title'=>'New Year Special',         'type'=>'fixed',     'value'=>500,  'nights'=>2,'limit'=>20,  'months'=>12],
            ['code'=>'FREESHIP',    'title'=>'Complimentary Discount',   'type'=>'fixed',     'value'=>200,  'nights'=>1,'limit'=>null,'months'=>12],
            ['code'=>'PAYDAY20',    'title'=>'Payday Promo',             'type'=>'percentage','value'=>20,   'nights'=>1,'limit'=>100, 'months'=>12],
            ['code'=>'REFERRAL10',  'title'=>'Referral Reward',          'type'=>'percentage','value'=>10,   'nights'=>1,'limit'=>null,'months'=>12],
        ];

        foreach ($promos as $p) {
            Promotion::updateOrCreate(
                ['code' => $p['code']],
                [
                    'title'          => $p['title'],
                    'description'    => $p['title'],
                    'discount_type'  => $p['type'],
                    'discount_value' => $p['value'],
                    'minimum_nights' => $p['nights'],
                    'minimum_amount' => 0,
                    'valid_from'     => $now,
                    'valid_until'    => $now->copy()->addMonths($p['months']),
                    'usage_limit'    => $p['limit'],
                    'used_count'     => 0,
                    'is_active'      => true,
                ]
            );
        }
    }
}
