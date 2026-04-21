<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superadmin = User::firstOrCreate(
            ['email' => 'superadmin@local.test'],
            [
                'name' => 'Super Admin',
                'employee_id' => 'EMP-0001',
                'phone' => '081234567890',
                'department' => 'IT',
                'position' => 'Super Admin',
                'is_active' => true,
                'password' => Hash::make('password'),
            ]
        );

        if (! $superadmin->hasRole('superadmin')) {
            $superadmin->assignRole('superadmin');
        }

        $manager = User::firstOrCreate(
            ['email' => 'manager@local.test'],
            [
                'name' => 'Manager',
                'employee_id' => 'EMP-0002',
                'phone' => '081234567891',
                'department' => 'Management',
                'position' => 'Manager',
                'is_active' => true,
                'password' => Hash::make('password'),
            ]
        );

        if (! $manager->hasRole('manager')) {
            $manager->assignRole('manager');
        }

        $finance = User::firstOrCreate(
            ['email' => 'finance@local.test'],
            [
                'name' => 'Finance',
                'employee_id' => 'EMP-0003',
                'phone' => '081234567892',
                'department' => 'Finance',
                'position' => 'Finance',
                'is_active' => true,
                'password' => Hash::make('password'),
            ]
        );

        if (! $finance->hasRole('finance')) {
            $finance->assignRole('finance');
        }

        $technician = User::firstOrCreate(
            ['email' => 'technician@local.test'],
            [
                'name' => 'Technician',
                'employee_id' => 'EMP-0004',
                'phone' => '081234567893',
                'department' => 'IT Support',
                'position' => 'Technician',
                'is_active' => true,
                'password' => Hash::make('password'),
            ]
        );

        if (! $technician->hasRole('technician')) {
            $technician->assignRole('technician');
        }

        $employee = User::firstOrCreate(
            ['email' => 'user@local.test'],
            [
                'name' => 'Karyawan',
                'employee_id' => 'EMP-0005',
                'phone' => '081234567894',
                'department' => 'General',
                'position' => 'Staff',
                'is_active' => true,
                'password' => Hash::make('password'),
            ]
        );

        if (! $employee->hasRole('user')) {
            $employee->assignRole('user');
        }
    }
}