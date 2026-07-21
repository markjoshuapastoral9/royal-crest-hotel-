<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create 
                            {--email= : Admin email address}
                            {--name= : Admin name}
                            {--password= : Admin password}
                            {--reset : Reset password for existing user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new admin user or reset existing admin password';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== Admin User Management ===');
        $this->newLine();

        // Get inputs
        $email = $this->option('email') ?: $this->ask('Admin email address');
        $name = $this->option('name') ?: $this->ask('Admin name', 'Admin User');
        $password = $this->option('password') ?: $this->secret('Admin password (default: password)') ?: 'password';

        // Validate email
        $validator = Validator::make(['email' => $email], [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            $this->error('Invalid email address!');
            return Command::FAILURE;
        }

        // Check if user exists
        $user = User::where('email', $email)->first();

        if ($user && $this->option('reset')) {
            // Reset password
            $user->password = Hash::make($password);
            $user->role = 'admin';
            $user->is_active = true;
            $user->email_verified_at = $user->email_verified_at ?? now();
            $user->save();
            $user->syncRoles(['admin']);

            $this->info('✅ Admin password reset successfully!');
        } elseif ($user) {
            if ($this->confirm('User already exists. Update to admin role and reset password?', true)) {
                $user->password = Hash::make($password);
                $user->role = 'admin';
                $user->is_active = true;
                $user->email_verified_at = $user->email_verified_at ?? now();
                $user->save();
                $user->syncRoles(['admin']);

                $this->info('✅ User updated to admin successfully!');
            } else {
                $this->warn('Operation cancelled.');
                return Command::SUCCESS;
            }
        } else {
            // Create new admin
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'role' => 'admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ]);
            $user->assignRole('admin');

            $this->info('✅ Admin user created successfully!');
        }

        // Display credentials
        $this->newLine();
        $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->line('Admin Login Credentials:');
        $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->line("Email:    {$user->email}");
        $this->line("Password: {$password}");
        $this->line("Name:     {$user->name}");
        $this->line("Status:   " . ($user->is_active ? 'Active' : 'Inactive'));
        $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');

        return Command::SUCCESS;
    }
}
