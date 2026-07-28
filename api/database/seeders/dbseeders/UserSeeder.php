<?php

namespace Database\Seeders\dbseeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $superAdminRoleId = 1;
        $adminRoleId = 2;
        $staffRoleId = 3;
        $userRoleId = 4;

        DB::table('users')->insert([
            [
                'name' => 'Super Admin',
                'email' => 'super_admin@mymedicalbilling.in',
                'phone' => '9000000000',
                'password' => Hash::make('superadminpassword'),
                'role_id' => $superAdminRoleId,
                'is_profile_complete' => false,
                'is_active' => true,
                'last_login_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Admin User',
                'email' => 'admin_user@mymedicalbilling.in',
                'phone' => '1234567890',
                'password' => Hash::make('adminuserpassword'),
                'role_id' => $adminRoleId,
                'is_profile_complete' => false,
                'is_active' => true,
                'last_login_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Staff User',
                'email' => 'staff_user@mymedicalbilling.in',
                'phone' => '1111111111',
                'password' => Hash::make('staffuserpassword'),
                'role_id' => $staffRoleId,
                'is_profile_complete' => false,
                'is_active' => true,
                'last_login_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'User',
                'email' => 'user@mymedicalbilling.in',
                'phone' => '2222222222',
                'password' => Hash::make('userpassword'),
                'role_id' => $userRoleId,
                'is_profile_complete' => true,
                'is_active' => true,
                'last_login_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Rani',
                'email' => 'john.smith@mymedicalbilling.in',
                'phone' => '3333333333',
                'password' => Hash::make('johnpassword'),
                'role_id' => $userRoleId,
                'is_profile_complete' => true,
                'is_active' => true,
                'last_login_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah.johnson@mymedicalbilling.in',
                'phone' => '4444444444',
                'password' => Hash::make('sarahpassword'),
                'role_id' => $userRoleId,
                'is_profile_complete' => true,
                'is_active' => true,
                'last_login_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Mike Wilson',
                'email' => 'mike.wilson@mymedicalbilling.in',
                'phone' => '5555555555',
                'password' => Hash::make('mikepassword'),
                'role_id' => $userRoleId,
                'is_profile_complete' => true,
                'is_active' => true,
                'last_login_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Emily Davis',
                'email' => 'emily.davis@mymedicalbilling.in',
                'phone' => '6666666666',
                'password' => Hash::make('emilypassword'),
                'role_id' => $userRoleId,
                'is_profile_complete' => true,
                'is_active' => true,
                'last_login_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'David Brown',
                'email' => 'david.brown@mymedicalbilling.in',
                'phone' => '7777777777',
                'password' => Hash::make('davidpassword'),
                'role_id' => $userRoleId,
                'is_profile_complete' => true,
                'is_active' => true,
                'last_login_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Lisa Anderson',
                'email' => 'lisa.anderson@mymedicalbilling.in',
                'phone' => '8888888888',
                'password' => Hash::make('lisapassword'),
                'role_id' => $userRoleId,
                'is_profile_complete' => false,
                'is_active' => true,
                'last_login_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Priya Mehta',
                'email' => 'priya.mehta@mymedicalbilling.in',
                'phone' => '9999999999',
                'password' => Hash::make('priyapassword'),
                'role_id' => $userRoleId,
                'is_profile_complete' => true,
                'is_active' => true,
                'last_login_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}