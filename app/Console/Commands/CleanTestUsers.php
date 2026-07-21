<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CleanTestUsers extends Command
{
    protected $signature = 'users:clean-test';
    protected $description = 'Remove test users with fake @example.com emails';

    public function handle()
    {
        // Get all test users with @example.com emails
        $testUsers = User::where('role', 'customer')
                        ->where('email', 'like', '%@example.com')
                        ->get();
        
        if ($testUsers->count() === 0) {
            $this->info('✅ No test users with @example.com found. Database is clean!');
            return 0;
        }
        
        $count = $testUsers->count();
        $this->warn("Found {$count} test users with fake @example.com emails");
        
        foreach ($testUsers as $user) {
            $this->line("  Deleting: {$user->name} ({$user->email})");
            $user->delete();
        }
        
        $this->info("");
        $this->info("✅ Successfully deleted {$count} test user(s)!");
        $this->info("Your Email Blast will now only send to real email addresses.");
        
        return 0;
    }
}
