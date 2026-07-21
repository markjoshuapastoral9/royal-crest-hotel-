<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use App\Mail\PaymentInstructionsMail;
use Illuminate\Support\Facades\Mail;

class TestPaymentMail extends Command
{
    protected $signature = 'test:payment-mail {email?}';
    protected $description = 'Test payment instructions email';

    public function handle()
    {
        $email = $this->argument('email') ?? 'test@example.com';
        
        // Get the latest booking with gcash/maya/bank_transfer payment method
        $booking = Booking::whereIn('payment_method', ['gcash', 'maya', 'bank_transfer'])
            ->with('room')
            ->latest()
            ->first();

        if (!$booking) {
            $this->error('No booking found with GCash/Maya/Bank Transfer payment method.');
            return 1;
        }

        $this->info("Sending payment instructions email to: {$email}");
        $this->info("Booking: {$booking->booking_number}");
        $this->info("Payment Method: {$booking->payment_method}");
        $this->info("Amount: ₱" . number_format($booking->total_amount, 2));

        try {
            Mail::to($email)->send(new PaymentInstructionsMail($booking));
            $this->info('✅ Payment instructions email sent successfully!');
            return 0;
        } catch (\Exception $e) {
            $this->error('❌ Failed to send email: ' . $e->getMessage());
            return 1;
        }
    }
}
