<?php

namespace Database\Seeders\dbseeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProfileActionSeeder extends Seeder
{
    public function run(): void
    {
        $profileActions = [
            [
                'from_profile_id' => 1,
                'to_profile_id' => 2,
                'action_type' => 'shortlist',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'from_profile_id' => 1,
                'to_profile_id' => 2,
                'action_type' => 'follow',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'from_profile_id' => 1,
                'to_profile_id' => 3,
                'action_type' => 'follow',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'from_profile_id' => 2,
                'to_profile_id' => 1,
                'action_type' => 'shortlist',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'from_profile_id' => 3,
                'to_profile_id' => 4,
                'action_type' => 'block',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('profile_actions')->insert($profileActions);
    }
}
