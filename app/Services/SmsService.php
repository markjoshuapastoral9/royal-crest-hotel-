<?php

namespace App\Services;

use App\Models\Booking;

class SmsService
{
    /**
     * Send payment instructions via SMS
     * 
     * Note: This is a placeholder. To actually send SMS, you would need to:
     * - Sign up for an SMS gateway service (e.g., Semaphore, Twilio, Vonage)
     * - Install their SDK: composer require twilio/sdk (for Twilio)
     * - Add API credentials to .env file
     * - Implement the actual API call here
     */
    public static function sendPaymentInstructions(Booking $booking)
    {
        $phone = $booking->guest_phone;
        $message = self::formatPaymentInstructionsMessage($booking);
        
        // TODO: Implement actual SMS sending here
        // Example for Semaphore API:
        // $client = new \GuzzleHttp\Client();
        // $client->post('https://api.semaphore.co/api/v4/messages', [
        //     'form_params' => [
        //         'apikey' => env('SEMAPHORE_API_KEY'),
        //         'number' => $phone,
        //         'message' => $message,
        //         'sendername' => 'ROYALCREST'
        //     ]
        // ]);
        
        // For now, just log it
        \Log::info("SMS would be sent to {$phone}: {$message}");
        
        return true;
    }
    
    private static function formatPaymentInstructionsMessage(Booking $booking)
    {
        $method = strtoupper(str_replace('_', ' ', $booking->payment_method));
        $amount = number_format($booking->total_amount, 2);
        
        $accountInfo = match($booking->payment_method) {
            'gcash' => "GCash: 0917 123 4567 (ROYAL CREST HOTEL)",
            'maya' => "Maya: 0917 123 4567 (ROYAL CREST HOTEL)",
            'bank_transfer' => "BDO: 123-456-789012 (ROYAL CREST HOTEL INC)",
            default => ""
        };
        
        return "ROYAL CREST HOTEL: Payment for booking {$booking->booking_number}. Amount: PHP {$amount}. {$accountInfo}. Use booking# as reference. Upload proof at royalcresthotel.com";
    }
}
