<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'view dashboard',

            'manage users',
            'manage roles',
            'manage assets',

            'view maintenance',
            'create maintenance',
            'verify maintenance',
            'assign maintenance',
            'work maintenance',
            'complete maintenance',

            'view procurement',
            'create procurement',
            'verify procurement',
            'review finance procurement',
            'complete procurement',

            'view audit logs',
            'view login logs',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $superadmin = Role::firstOrCreate(['name' => 'superadmin']);
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $manager = Role::firstOrCreate(['name' => 'manager']);
        $technician = Role::firstOrCreate(['name' => 'technician']);
        $finance = Role::firstOrCreate(['name' => 'finance']);
        $user = Role::firstOrCreate(['name' => 'user']);

        $superadmin->syncPermissions(Permission::all());

        $admin->syncPermissions([
            'view dashboard',
            'manage users',
            'manage assets',
            'view maintenance',
            'assign maintenance',
            'view procurement',
            'view audit logs',
            'view login logs',
        ]);

        $manager->syncPermissions([
            'view dashboard',
            'view maintenance',
            'verify maintenance',
            'view procurement',
            'verify procurement',
        ]);

        $technician->syncPermissions([
            'view dashboard',
            'view maintenance',
            'work maintenance',
            'complete maintenance',
        ]);

        $finance->syncPermissions([
            'view dashboard',
            'view procurement',
            'review finance procurement',
            'complete procurement',
        ]);

        $user->syncPermissions([
            'view dashboard',
            'create maintenance',
            'create procurement',
            'view maintenance',
            'view procurement',
        ]);
    }
}