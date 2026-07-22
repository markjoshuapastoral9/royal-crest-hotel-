<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@royalcresthotel.com'],
            [
                'name'              => 'Admin Royal Crest',
                'password'          => Hash::make('password'),
                'role'              => 'admin',
                'phone'             => '+63 912 345 6789',
                'address'           => 'Calasiao, Pangasinan, Philippines',
                'is_active'         => true,
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole('admin');

        // Staff
        $staff = User::firstOrCreate(
            ['email' => 'staff@monarchhotel.com'],
            [
                'name'              => 'Staff Member',
                'password'          => Hash::make('password'),
                'role'              => 'staff',
                'phone'             => '+63 912 345 6780',
                'address'           => 'Dagupan City, Pangasinan',
                'is_active'         => true,
                'email_verified_at' => now(),
            ]
        );
        $staff->assignRole('staff');

        // Sample customers
        $customers = [
            ['name' => 'Maria Santos',    'email' => 'maria@example.com'],
            ['name' => 'Juan dela Cruz',  'email' => 'juan@example.com'],
            ['name' => 'Ana Reyes',       'email' => 'ana@example.com'],
            ['name' => 'Carlos Mendoza',  'email' => 'carlos@example.com'],
            ['name' => 'Grace Villanueva','email' => 'grace@example.com'],
            ['name' => 'Robert Lim',      'email' => 'robert@example.com'],
            ['name' => 'Patricia Cruz',   'email' => 'patricia@example.com'],
            ['name' => 'Michael Torres',  'email' => 'michael@example.com'],
            ['name' => 'Jennifer Bautista','email'=> 'jennifer@example.com'],
            ['name' => 'David Ramos',     'email' => 'david@example.com'],
        ];

        foreach ($customers as $customer) {
            $user = User::firstOrCreate(
                ['email' => $customer['email']],
                [
                    'name'              => $customer['name'],
                    'password'          => Hash::make('password'),
                    'role'              => 'customer',
                    'phone'             => '+63 9' . rand(10,99) . ' ' . rand(100,999) . ' ' . rand(1000,9999),
                    'is_active'         => true,
                    'email_verified_at' => now(),
                ]
            );
            $user->assignRole('customer');
        }
    }
}
