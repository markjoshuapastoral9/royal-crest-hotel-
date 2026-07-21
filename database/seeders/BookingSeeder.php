<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\Room;
use App\Models\User;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $rooms    = Room::all();
        $customers = User::where('role', 'customer')->get();

        if ($rooms->isEmpty() || $customers->isEmpty()) return;

        $statuses = ['pending', 'confirmed', 'checked_in', 'checked_out', 'completed', 'cancelled'];
        $methods  = ['cash', 'gcash', 'maya', 'bank_transfer'];

        for ($i = 0; $i < 30; $i++) {
            $room     = $rooms->random();
            $customer = $customers->random();
            $checkIn  = now()->subDays(rand(1, 90))->format('Y-m-d');
            $checkOut = date('Y-m-d', strtotime($checkIn . ' +' . rand(1, 7) . ' days'));
            $nights   = \Carbon\Carbon::parse($checkIn)->diffInDays($checkOut);
            $subtotal = $nights * $room->price_per_night;
            $tax      = round($subtotal * 0.12, 2);
            $total    = $subtotal + $tax;
            $status   = $statuses[array_rand($statuses)];

            $year  = date('Y', strtotime($checkIn));
            $count = Booking::count() + 1;
            $bookingNumber = 'SUB-' . $year . '-' . str_pad($count, 6, '0', STR_PAD_LEFT);

            Booking::create([
                'booking_number'       => $bookingNumber,
                'user_id'              => $customer->id,
                'room_id'              => $room->id,
                'guest_name'           => $customer->name,
                'guest_email'          => $customer->email,
                'guest_phone'          => $customer->phone ?? '+63 912 345 6789',
                'check_in'             => $checkIn,
                'check_out'            => $checkOut,
                'adults'               => rand(1, $room->capacity),
                'children'             => rand(0, 1),
                'nights'               => $nights,
                'room_price_per_night' => $room->price_per_night,
                'subtotal'             => $subtotal,
                'discount_amount'      => 0,
                'tax_amount'           => $tax,
                'total_amount'         => $total,
                'payment_method'       => $methods[array_rand($methods)],
                'payment_status'       => in_array($status, ['confirmed','checked_in','checked_out','completed']) ? 'paid' : 'unpaid',
                'status'               => $status,
                'confirmed_at'         => in_array($status, ['confirmed','checked_in','checked_out','completed']) ? now()->subDays(rand(1,30)) : null,
                'checked_in_at'        => in_array($status, ['checked_in','checked_out','completed']) ? now()->subDays(rand(1,20)) : null,
                'checked_out_at'       => in_array($status, ['checked_out','completed']) ? now()->subDays(rand(0,10)) : null,
                'cancelled_at'         => $status === 'cancelled' ? now()->subDays(rand(1,30)) : null,
                'created_at'           => now()->subDays(rand(0, 90)),
                'updated_at'           => now()->subDays(rand(0, 30)),
            ]);
        }
    }
}
