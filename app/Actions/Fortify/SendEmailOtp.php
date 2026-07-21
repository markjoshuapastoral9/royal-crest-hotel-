<?php

namespace App\Actions\Fortify;

use App\Mail\OtpMail;
use App\Models\OtpVerification;
use Illuminate\Support\Facades\Mail;

/**
 * Jetstream Email OTP Action
 *
 * Called after successful credential verification.
 * Generates a 6-digit OTP and sends it via Laravel Mail (not PHPMailer).
 * Integrates with Jetstream's TwoFactorAuthenticatable pipeline.
 */
class SendEmailOtp
{
    public function send($user): array
    {
        $result = OtpVerification::generateFor($user);

        try {
            Mail::to($user->email)->send(new OtpMail($result['code'], $user->name));
        } catch (\Exception $e) {
            \Log::error('Jetstream Email OTP send failed: ' . $e->getMessage());
        }

        return $result;
    }
}
