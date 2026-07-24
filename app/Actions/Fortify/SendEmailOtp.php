<?php

namespace App\Actions\Fortify;

use App\Mail\OtpMail;
use App\Models\OtpVerification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmailOtp
{
    public function send($user): array
    {
        $result = OtpVerification::generateFor($user);

        try {
            Mail::to($user->email)->send(new OtpMail($result['code'], $user->name));
            Log::info('OTP sent successfully to: ' . $user->email);
        } catch (\Exception $e) {
            Log::error('OTP send FAILED for ' . $user->email . ': ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
        }

        return $result;
    }
}
