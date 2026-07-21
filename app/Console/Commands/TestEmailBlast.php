<?php

namespace App\Console\Commands;

use App\Mail\EmailBlastMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestEmailBlast extends Command
{
    protected $signature = 'email:test-blast {email}';
    protected $description = 'Send a test email blast to verify email configuration';

    public function handle()
    {
        $email = $this->argument('email');
        
        $this->info("Sending test email blast to: {$email}");
        
        try {
            Mail::to($email)->send(
                new EmailBlastMail(
                    'Test Email Blast - The Royal Crest',
                    '<b>This is a test email!</b><br><br>If you receive this, your email blast feature is working correctly.<br><br>You can now send promotional emails to all your guests!',
                    'Test User'
                )
            );
            
            $this->info("✅ Test email sent successfully!");
            $this->info("Check your inbox at: {$email}");
            
        } catch (\Exception $e) {
            $this->error("❌ Failed to send email: " . $e->getMessage());
            return 1;
        }
        
        return 0;
    }
}
