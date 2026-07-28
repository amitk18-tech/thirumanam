<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Log;
use Bits\Package\Policies\BasePolicy;

class ProfilePolicy extends BasePolicy
{
    public function viewAny(User $user, Profile $profile = null)
    {
        Log::info('Checking viewAny permission for Profile', ['user_id' => $user->id, 'permission' => $user->getPermissions()]);
        return $user->hasPermission('view_profiles');
    }

    public function view(User $user, Profile $profile)
    {
        // Allow if they own it
        if ($user->id === $profile->user_id) {
            return true;
        }

        // Otherwise require permission
        return $user->hasPermission('view_profiles');
    }


    public function create(User $user)
    {
        Log::info('Checking create permission for Profile', [
            'user_id' => $user->id,
            'role' => $user->role->slug ?? null,
        ]);

        // 1️⃣ Admin or staff can create profiles for others
        if ($user->hasPermission('create_profiles')) {
            return true;
        }

        // 2️⃣ Normal user: only if they don’t already have a profile
        $existingProfile = $user->profile()->exists();

        if ($user->role->slug === 'user' && !$existingProfile && !$user->is_profile_complete) {
            return true;
        }

        return false;
    }



    public function update(User $user, Profile $profile)
    {

        // Allow if they own it
        if ($user->id === $profile->user_id) {
            return true;
        }

        return $user->hasPermission('update_profiles');
    }

    public function delete(User $user, Profile $profile)
    {
        // Allow if they own it
        if ($user->id === $profile->user_id) {
            return true;
        }

        return $user->hasPermission('delete_profiles');
    }

    public function bulkDelete(User $user)
    {
        return $user->hasPermission('bulk_delete_profiles');
    }

    //approve
    public function approve(User $user, Profile $profile)
    {
        return $user->hasPermission('approve_profiles');
    }


    // block
    public function block(User $user, Profile $profile)
    {
        return $user->hasPermission('block_profiles');
    }

    // reject
    public function reject(User $user, Profile $profile)
    {
        return $user->hasPermission('reject_profiles');
    }
}