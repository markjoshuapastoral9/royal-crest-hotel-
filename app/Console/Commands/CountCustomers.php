<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CountCustomers extends Command
{
    protected $signature = 'users:count';
    protected $description = 'Show customer user count';

    public function handle()
    {
        $total = User::where('role', 'customer')->count();
        $active = User::where('role', 'customer')->where('is_active', true)->count();
        
        $this->info("📊 Customer Statistics:");
        $this->info("   Total customers: {$total}");
        $this->info("   Active customers: {$active}");
        
        if ($total > 0) {
            $this->info("");
            $this->info("Recent customers:");
            $users = User::where('role', 'customer')->latest()->limit(5)->get();
            foreach ($users as $user) {
                $status = $user->is_active ? '✅' : '❌';
                $this->line("   {$status} {$user->name} ({$user->email})");
            }
        }
        
        return 0;
    }
}
