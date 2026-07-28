<?php

namespace Database\Seeders\dbseeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Replace 1 with the appropriate tenant_id as needed

        DB::table('roles')->insert([
            [
                'name'        => 'super admin',
                'slug'        => 'super_admin',
                'description' => 'Super Administrator role',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'admin',
                'slug'        => 'admin',
                'description' => 'Administrator role',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'staff',
                'slug'        => 'staff',
                'description' => 'Staff role',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'user',
                'slug'        => 'user',
                'description' => 'User role',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}