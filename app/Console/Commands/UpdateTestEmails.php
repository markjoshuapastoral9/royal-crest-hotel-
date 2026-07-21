<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class UpdateTestEmails extends Command
{
    protected $signature = 'users:update-test-emails {your-email}';
    protected $description = 'Update test user emails to a real email for testing';

    public function handle()
    {
        $yourEmail = $this->argument('your-email');
        
        // Get all test users with @example.com emails
        $testUsers = User::where('role', 'customer')
                        ->where('email', 'like', '%@example.com')
                        ->get();
        
        if ($testUsers->count() === 0) {
            $this->warn('No test users with @example.com found.');
            return 0;
        }
        
        $this->info("Found {$testUsers->count()} test users with @example.com emails");
        
        // Update only the first one to your email
        $firstUser = $testUsers->first();
        $oldEmail = $firstUser->email;
        
        $firstUser->email = $yourEmail;
        $firstUser->save();
        
        $this->info("✅ Updated test user:");
        $this->info("   Name: {$firstUser->name}");
        $this->info("   Old email: {$oldEmail}");
        $this->info("   New email: {$yourEmail}");
        $this->info("");
        $this->info("Now you can test Email Blast and it will be sent to your inbox!");
        
        return 0;
    }
}
