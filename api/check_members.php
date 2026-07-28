<?php

use App\Models\Profile;
use App\Models\Member;
use App\Models\User;

// 1. Find Profiles that don't have a Member record
$profilesWithoutMember = Profile::doesntHave('member')->get();

echo "Profiles without Member record: " . $profilesWithoutMember->count() . "\n";

foreach ($profilesWithoutMember as $profile) {
    echo "Profile ID: {$profile->id}, User ID: {$profile->user_id}\n";
    $user = User::find($profile->user_id);
    if ($user) {
        echo "  -> User: {$user->name} ({$user->email}), Role: {$user->role_id}\n";
    } else {
        echo "  -> ORPHAN PROFILE (No User)\n";
    }
}

// 2. Check current user concept (if possible, but hard in CLI without auth context)
// We will just look for the admin user specifically if commonly used
$admin = User::where('email', 'admin@example.com')->first(); // Common guess
if ($admin) {
    echo "\nCheck Admin User:\n";
    $adminProfile = Profile::where('user_id', $admin->id)->first();
    echo "Admin Profile: " . ($adminProfile ? "Yes (ID: {$adminProfile->id})" : "No") . "\n";
    if ($adminProfile) {
        $adminMember = Member::where('profile_id', $adminProfile->id)->first();
        echo "Admin Member: " . ($adminMember ? "Yes (ID: {$adminMember->id})" : "No") . "\n";
    }
}
