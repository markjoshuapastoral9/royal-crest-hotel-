<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestMail extends Command
{
    protected $signature = 'mail:test {email}';
    protected $description = 'Test Gmail SMTP configuration';

    public function handle(): void
    {
        $email = $this->argument('email');

        $this->info("Sending test email to: {$email}");

        try {
            Mail::raw(
                "✅ Gmail SMTP is working!\n\nThis is a test email from Monarch Hotel Booking System.\n\nIf you received this, your Gmail configuration is correct.",
                function ($message) use ($email) {
                    $message->to($email)
                            ->subject('✅ Monarch Hotel — Mail Test Successful');
                }
            );
            $this->info('✅ Email sent successfully! Check your inbox.');
        } catch (\Exception $e) {
            $this->error('❌ Failed: ' . $e->getMessage());
        }
    }
}
