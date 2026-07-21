<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'manage-rooms', 'manage-bookings', 'manage-users',
            'manage-payments', 'manage-settings', 'view-reports',
            'manage-gallery', 'manage-facilities', 'manage-promotions',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $admin->givePermissionTo(Permission::all());

        $staff = Role::firstOrCreate(['name' => 'staff', 'guard_name' => 'web']);
        $staff->givePermissionTo(['manage-rooms', 'manage-bookings', 'manage-payments', 'view-reports']);

        Role::firstOrCreate(['name' => 'customer', 'guard_name' => 'web']);
    }
}
