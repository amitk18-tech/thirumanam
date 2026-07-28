<?php

namespace Database\Seeders\dbseeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ProfileReportsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('profile_reports')->insert([
            [
                'reported_by_profile_id' => 1,
                'reported_profile_id' => 2,
                'reason' => 'Inappropriate Content',
                'description' => 'Profile contains inappropriate images and language.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'reported_by_profile_id' => 3,
                'reported_profile_id' => 4,
                'reason' => 'Fake Profile',
                'description' => 'Profile appears to be using fake information.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'reported_by_profile_id' => 5,
                'reported_profile_id' => 6,
                'reason' => 'Harassment',
                'description' => 'User has been sending unwanted messages.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}