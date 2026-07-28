<?php

namespace Database\Seeders\dbseeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MembershipsSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        DB::table('memberships')->insert([

            [
                'name' => 'Default',
                'slug' => 'default',
                'price' => 0,
                'duration_days' => 0,
                'sent_interest_allowed' => 0,
                'profiles_view_allowed' => 0,
                'messages_sent_allowed' => 0,
                'membership_mode' => 'online',
                'savaran_plan' => null,
                'start_date' => null,
                'end_date' => null,
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            [
                'name' => 'Yellow',
                'slug' => 'yellow',
                'price' => 1,
                'duration_days' => 180,
                'sent_interest_allowed' => 10,
                'profiles_view_allowed' => 10,
                'messages_sent_allowed' => 10,
                'membership_mode' => 'offline',
                'savaran_plan' => 25,
                'start_date' => $now,
                'end_date' => $now->copy()->addDays(180),
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            [
                'name' => 'Green',
                'slug' => 'green',
                'price' => 2,
                'duration_days' => 180,
                'sent_interest_allowed' => 100,
                'profiles_view_allowed' => 100,
                'messages_sent_allowed' => 10,
                'membership_mode' => 'offline',
                'savaran_plan' => 50,
                'start_date' => $now,
                'end_date' => $now->copy()->addDays(180),
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            [
                'name' => 'Blue',
                'slug' => 'blue',
                'price' => 3,
                'duration_days' => 180,
                'sent_interest_allowed' => 100,
                'profiles_view_allowed' => 100,
                'messages_sent_allowed' => 10,
                'membership_mode' => 'offline',
                'savaran_plan' => 9999,
                'start_date' => $now,
                'end_date' => $now->copy()->addDays(180),
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            [
                'name' => 'Essential',
                'slug' => 'essential',
                'price' => 1,
                'duration_days' => 180,
                'sent_interest_allowed' => 100,
                'profiles_view_allowed' => 100,
                'messages_sent_allowed' => 10,
                'membership_mode' => 'online',
                'savaran_plan' => 25,
                'start_date' => $now,
                'end_date' => $now->copy()->addDays(180),
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            [
                'name' => 'Classic',
                'slug' => 'classic',
                'price' => 2,
                'duration_days' => 180,
                'sent_interest_allowed' => 100,
                'profiles_view_allowed' => 100,
                'messages_sent_allowed' => 10,
                'membership_mode' => 'online',
                'savaran_plan' => 50,
                'start_date' => $now,
                'end_date' => $now->copy()->addDays(180),
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            [
                'name' => 'Prime',
                'slug' => 'prime',
                'price' => 3,
                'duration_days' => 180,
                'sent_interest_allowed' => 10,
                'profiles_view_allowed' => 10,
                'messages_sent_allowed' => 10,
                'savaran_plan' => 9999, // unlimited
                'membership_mode' => 'online',
                'start_date' => $now,
                'end_date' => $now->copy()->addDays(180),
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],


        ]);
    }
}