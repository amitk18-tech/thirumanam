<?php

namespace Database\Seeders\dbseeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;



class InterestsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $interests = [
            [
                'sender_profile_id' => 1,
                'receiver_profile_id' => 2,
                'status' => 'pending',
                'responded_at' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'sender_profile_id' => 1,
                'receiver_profile_id' => 3,
                'status' => 'accepted',
                'responded_at' => Carbon::now()->subDays(2),
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'sender_profile_id' => 1,
                'receiver_profile_id' => 4,
                'status' => 'rejected',
                'responded_at' => Carbon::now()->subDay(),
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDay(),
            ],
        ];

        DB::table('interests')->insert($interests);
    }
}