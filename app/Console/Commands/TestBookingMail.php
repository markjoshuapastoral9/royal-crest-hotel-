<?php

namespace App\Console\Commands;

use App\Mail\BookingConfirmationMail;
use App\Models\Booking;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestBookingMail extends Command
{
    protected $signature = 'mail:booking-test {email}';
    protected $description = 'Test booking confirmation email with room image';

    public function handle(): void
    {
        $email = $this->argument('email');
        $booking = Booking::with(['room.roomType'])->latest()->first();

        if (!$booking) {
            $this->error('No bookings found in database.');
            return;
        }

        $this->info("Sending booking confirmation for: {$booking->booking_number}");
        $this->info("Room: {$booking->room->name}");
        $this->info("To: {$email}");

        try {
            Mail::to($email)->send(new BookingConfirmationMail($booking));
            $this->info('✅ Booking confirmation email sent! Check your inbox.');
        } catch (\Exception $e) {
            $this->error('❌ Failed: ' . $e->getMessage());
        }
    }
}
