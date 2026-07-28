<?php

namespace Database\Seeders\dbseeders;

use Illuminate\Database\Seeder;
use App\Models\Profile;
use App\Models\Member;
use App\Models\Membership;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {




        Member::create([

            'profile_id' => 1,
            'membership_id' => 5,
            'start_date' => now(),
            'end_date' => now()->addYear(),
            'sent_interest_allowed' => 10,
            'profiles_view_allowed' => 100,
            'messages_sent_allowed' => 10,

            'sent_interest_remaining' => 100,
            'profiles_view_remaining' => 100,
            'messages_sent_remaining' => 10,

            'membership_expired' => false,
            'send_reminder' => true,
            'auto_renewal' => true,
            'status' => 'active',
            'is_verified' => true,
            'is_reported' => false,
            'is_deactivated' => false,
            'is_matched' => false,
            'verified_by_admin' => true,
            'blocked_by_admin' => false,
            'rejected_by_admin' => false,
            'rejection_reason' => null,

            'member_no' => 'MEM001',
            'created_at' => now()->subMonth()
        ]);

        Member::create([
            'profile_id' => 2,
            'membership_id' => 5,
            'start_date' => now(),
            'end_date' => now()->addMonths(6),
            'sent_interest_allowed' => 10,
            'profiles_view_allowed' => 100,
            'messages_sent_allowed' => 10,


            'sent_interest_remaining' => 100,
            'profiles_view_remaining' => 90,
            'messages_sent_remaining' => 1,

            'membership_expired' => false,
            'send_reminder' => true,
            'auto_renewal' => false,
            'status' => 'active',
            'is_verified' => true,
            'is_reported' => false,
            'is_deactivated' => false,
            'is_matched' => true,
            'verified_by_admin' => true,
            'blocked_by_admin' => false,
            'rejected_by_admin' => false,
            'rejection_reason' => null,

            'member_no' => 'MEM002'
        ]);

        Member::create([
            'profile_id' => 3,
            'membership_id' => 7,
            'start_date' => now()->subDays(30),
            'end_date' => now()->addMonths(11),
            'sent_interest_allowed' => 10,
            'profiles_view_allowed' => 100,
            'messages_sent_allowed' => 10,


            'sent_interest_remaining' => 8,
            'profiles_view_remaining' => 20,
            'messages_sent_remaining' => 10,

            'membership_expired' => false,
            'send_reminder' => false,
            'auto_renewal' => true,
            'status' => 'active',
            'is_verified' => false,
            'is_reported' => false,
            'is_deactivated' => false,
            'is_matched' => false,
            'verified_by_admin' => false,
            'blocked_by_admin' => false,
            'rejected_by_admin' => false,
            'rejection_reason' => null,

            'member_no' => 'MEM003'
        ]);

        Member::create([
            'profile_id' => 4,
            'membership_id' => 5,
            'start_date' => now()->subDays(15),
            'end_date' => now()->addMonths(3),
            'sent_interest_allowed' => 10,
            'profiles_view_allowed' => 100,
            'messages_sent_allowed' => 10,

            'sent_interest_remaining' => 66,
            'profiles_view_remaining' => 8,
            'messages_sent_remaining' => 4,

            'membership_expired' => false,
            'send_reminder' => true,
            'auto_renewal' => false,
            'status' => 'inactive',
            'is_verified' => true,
            'is_reported' => true,
            'is_deactivated' => false,
            'is_matched' => false,
            'verified_by_admin' => true,
            'blocked_by_admin' => false,
            'rejected_by_admin' => false,
            'rejection_reason' => null,

            'member_no' => 'MEM004'
        ]);

        Member::create([
            'profile_id' => 5,
            'membership_id' => 2,
            'start_date' => now()->subDays(60),
            'end_date' => now()->subDays(10),
            'sent_interest_allowed' => 10,
            'profiles_view_allowed' => 100,
            'messages_sent_allowed' => 10,

            'sent_interest_remaining' => 7,
            'profiles_view_remaining' => 45,
            'messages_sent_remaining' => 10,

            'membership_expired' => true,
            'send_reminder' => true,
            'auto_renewal' => false,
            'status' => 'expired',
            'is_verified' => true,
            'is_reported' => false,
            'is_deactivated' => true,
            'is_matched' => true,
            'verified_by_admin' => true,
            'blocked_by_admin' => false,
            'rejected_by_admin' => false,
            'rejection_reason' => null,

            'member_no' => 'MEM005'
        ]);

        Member::create([
            'profile_id' => 6,
            'membership_id' => 3,
            'start_date' => now()->subDays(5),
            'end_date' => now()->addYear(),
            'sent_interest_allowed' => 10,
            'profiles_view_allowed' => 100,
            'messages_sent_allowed' => 10,

            'sent_interest_remaining' => 0,
            'profiles_view_remaining' => 0,
            'messages_sent_remaining' => 0,

            'membership_expired' => false,
            'send_reminder' => false,
            'auto_renewal' => true,
            'status' => 'pending',
            'is_verified' => false,
            'is_reported' => false,
            'is_deactivated' => false,
            'is_matched' => false,
            'verified_by_admin' => false,
            'blocked_by_admin' => false,
            'rejected_by_admin' => true,
            'rejection_reason' => 'Incomplete profile information',

            'member_no' => 'MEM006'
        ]);

        Member::create([
            'profile_id' => 7,
            'membership_id' => 1,
            'start_date' => now(),
            'end_date' => now()->addMonths(3),
            'sent_interest_allowed' => 10,
            'profiles_view_allowed' => 100,
            'messages_sent_allowed' => 10,

            'sent_interest_remaining' => 0,
            'profiles_view_remaining' => 0,
            'messages_sent_remaining' => 0,

            'membership_expired' => false,
            'send_reminder' => true,
            'auto_renewal' => false,
            'status' => 'active',
            'is_verified' => true,
            'is_reported' => false,
            'is_deactivated' => false,
            'is_matched' => true,
            'verified_by_admin' => true,
            'blocked_by_admin' => true,
            'rejected_by_admin' => false,
            'rejection_reason' => null,

            'member_no' => 'MEM007'
        ]);

        Member::create([
            'profile_id' => 8,
            'membership_id' => 4,
            'start_date' => now()->subDays(10),
            'end_date' => now()->addMonths(6),
            'sent_interest_allowed' => 10,
            'profiles_view_allowed' => 100,
            'messages_sent_allowed' => 10,

            'sent_interest_remaining' => 10,
            'profiles_view_remaining' => 55,
            'messages_sent_remaining' => 15,

            'membership_expired' => false,
            'send_reminder' => true,
            'auto_renewal' => true,
            'status' => 'active',
            'is_verified' => true,
            'is_reported' => false,
            'is_deactivated' => false,
            'is_matched' => false,
            'verified_by_admin' => true,
            'blocked_by_admin' => false,
            'rejected_by_admin' => false,
            'rejection_reason' => null,

            'member_no' => 'MEM008'
        ]);
    }
}