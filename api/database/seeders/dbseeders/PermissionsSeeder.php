<?php

namespace Database\Seeders\dbseeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [

            // ------------------- Profiles ------------------- //
            ['name' => 'view_profiles', 'label' => 'View Profiles', 'module' => 'profiles'],
            ['name' => 'create_profiles', 'label' => 'Create Profiles', 'module' => 'profiles'],
            ['name' => 'update_profiles', 'label' => 'Update Profiles', 'module' => 'profiles'],
            ['name' => 'delete_profiles', 'label' => 'Delete Profiles', 'module' => 'profiles'],

            // ------------------- Family Details ------------------- //
            ['name' => 'view_family_details', 'label' => 'View Family Details', 'module' => 'family_detail'],
            ['name' => 'create_family_details', 'label' => 'Create Family Details', 'module' => 'family_detail'],
            ['name' => 'update_family_details', 'label' => 'Update Family Details', 'module' => 'family_detail'],
            ['name' => 'delete_family_details', 'label' => 'Delete Family Details', 'module' => 'family_detail'],

            // ------------------- Partner Preferences ------------------- //
            ['name' => 'view_partner_preferences', 'label' => 'View Partner Preferences', 'module' => 'partner_preference'],
            ['name' => 'create_partner_preferences', 'label' => 'Create Partner Preferences', 'module' => 'partner_preference'],
            ['name' => 'update_partner_preferences', 'label' => 'Update Partner Preferences', 'module' => 'partner_preference'],
            ['name' => 'delete_partner_preferences', 'label' => 'Delete Partner Preferences', 'module' => 'partner_preference'],

            // ------------------- Photos ------------------- //
            ['name' => 'view_photos', 'label' => 'View Photos', 'module' => 'photo'],
            ['name' => 'create_photos', 'label' => 'Create Photos', 'module' => 'photo'],
            ['name' => 'update_photos', 'label' => 'Update Photos', 'module' => 'photo'],
            ['name' => 'delete_photos', 'label' => 'Delete Photos', 'module' => 'photo'],

            // ------------------- Messages ------------------- //
            ['name' => 'view_messages', 'label' => 'View Messages', 'module' => 'message'],
            ['name' => 'create_messages', 'label' => 'Create Messages', 'module' => 'message'],
            ['name' => 'update_messages', 'label' => 'Update Messages', 'module' => 'message'],
            ['name' => 'delete_messages', 'label' => 'Delete Messages', 'module' => 'message'],

            // ------------------- Memberships ------------------- //
            ['name' => 'view_memberships', 'label' => 'View Memberships', 'module' => 'membership'],
            ['name' => 'create_memberships', 'label' => 'Create Memberships', 'module' => 'membership'],
            ['name' => 'update_memberships', 'label' => 'Update Memberships', 'module' => 'membership'],
            ['name' => 'delete_memberships', 'label' => 'Delete Memberships', 'module' => 'membership'],

            // ------------------- Horoscope Boxes ------------------- //
            ['name' => 'view_horoscope_boxes', 'label' => 'View Horoscope Boxes', 'module' => 'horoscope_box'],
            ['name' => 'create_horoscope_boxes', 'label' => 'Create Horoscope Boxes', 'module' => 'horoscope_box'],
            ['name' => 'update_horoscope_boxes', 'label' => 'Update Horoscope Boxes', 'module' => 'horoscope_box'],
            ['name' => 'delete_horoscope_boxes', 'label' => 'Delete Horoscope Boxes', 'module' => 'horoscope_box'],

            // ------------------- Payments ------------------- //
            ['name' => 'view_payments', 'label' => 'View Payments', 'module' => 'payment'],
            ['name' => 'create_payments', 'label' => 'Create Payments', 'module' => 'payment'],
            ['name' => 'update_payments', 'label' => 'Update Payments', 'module' => 'payment'],
            ['name' => 'delete_payments', 'label' => 'Delete Payments', 'module' => 'payment'],

            // ------------------- Profile Verification Logs ------------------- //
            ['name' => 'view_profile_verification_logs', 'label' => 'View Profile Verification Logs', 'module' => 'profile_verification_log'],
            ['name' => 'create_profile_verification_logs', 'label' => 'Create Profile Verification Logs', 'module' => 'profile_verification_log'],
            ['name' => 'update_profile_verification_logs', 'label' => 'Update Profile Verification Logs', 'module' => 'profile_verification_log'],
            ['name' => 'delete_profile_verification_logs', 'label' => 'Delete Profile Verification Logs', 'module' => 'profile_verification_log'],

            // ------------------- Reports ------------------- //
            ['name' => 'view_reports', 'label' => 'View Reports', 'module' => 'report'],
            ['name' => 'create_reports', 'label' => 'Create Reports', 'module' => 'report'],
            ['name' => 'update_reports', 'label' => 'Update Reports', 'module' => 'report'],
            ['name' => 'delete_reports', 'label' => 'Delete Reports', 'module' => 'report'],

            // ------------------- Blocked Users ------------------- //
            ['name' => 'view_blocked_users', 'label' => 'View Blocked Users', 'module' => 'blocked_user'],
            ['name' => 'create_blocked_users', 'label' => 'Create Blocked Users', 'module' => 'blocked_user'],
            ['name' => 'update_blocked_users', 'label' => 'Update Blocked Users', 'module' => 'blocked_user'],
            ['name' => 'delete_blocked_users', 'label' => 'Delete Blocked Users', 'module' => 'blocked_user'],

            // ------------------- Users ------------------- //
            ['name' => 'view_users', 'label' => 'View Users', 'module' => 'users'],
            ['name' => 'create_users', 'label' => 'Create Users', 'module' => 'users'],
            ['name' => 'update_users', 'label' => 'Update Users', 'module' => 'users'],
            ['name' => 'delete_users', 'label' => 'Delete Users', 'module' => 'users'],
            ['name' => 'bulk_delete_users', 'label' => 'Bulk Delete Users', 'module' => 'users'],

            // ------------------- Members ------------------- //
            ['name' => 'view_members', 'label' => 'View Members', 'module' => 'members'],
            ['name' => 'create_members', 'label' => 'Create Members', 'module' => 'members'],
            ['name' => 'update_members', 'label' => 'Update Members', 'module' => 'members'],
            ['name' => 'delete_members', 'label' => 'Delete Members', 'module' => 'members'],
            ['name' => 'bulk_delete_members', 'label' => 'Bulk Delete Members', 'module' => 'members'],

            // ------------------- Admin Activities ------------------- //
            ['name' => 'view_admin_activities', 'label' => 'View Admin Activities', 'module' => 'admin_activities'],
            ['name' => 'create_admin_activities', 'label' => 'Create Admin Activities', 'module' => 'admin_activities'],
            ['name' => 'update_admin_activities', 'label' => 'Update Admin Activities', 'module' => 'admin_activities'],
            ['name' => 'delete_admin_activities', 'label' => 'Delete Admin Activities', 'module' => 'admin_activities'],

            // ------------------- Member Activities ------------------- //
            ['name' => 'view_member_activities', 'label' => 'View Member Activities', 'module' => 'member_activities'],
            ['name' => 'create_member_activities', 'label' => 'Create Member Activities', 'module' => 'member_activities'],
            ['name' => 'update_member_activities', 'label' => 'Update Member Activities', 'module' => 'member_activities'],
            ['name' => 'delete_member_activities', 'label' => 'Delete Member Activities', 'module' => 'member_activities'],

            // ------------------- Overview ------------------- //
            ['name' => 'view_overview', 'label' => 'View Overview', 'module' => 'overview'],
        ];

        foreach ($permissions as $permission) {
            DB::table('permissions')->updateOrInsert(
                ['name' => $permission['name']],   // UNIQUE key
                [
                    'label' => $permission['label'],
                    'module' => $permission['module'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}