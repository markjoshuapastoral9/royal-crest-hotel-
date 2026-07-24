<?php

namespace App\Console\Commands;

use App\Mail\OtpMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestOtpMail extends Command
{
    protected $signature = 'mail:test-otp {email}';
    protected $description = 'Test OTP mail sending';

    public function handle()
    {
        $email = $this->argument('email');
        $this->info('Sending test OTP to: ' . $email);
        
        try {
            Mail::to($email)->send(new OtpMail('123456', 'Test User'));
            $this->info('SUCCESS! Mail sent to ' . $email);
        } catch (\Exception $e) {
            $this->error('FAILED: ' . $e->getMessage());
        }
    }
}
