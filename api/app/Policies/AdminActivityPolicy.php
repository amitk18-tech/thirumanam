<?php

namespace App\Policies;

use App\Models\User;
use App\Models\AdminActivity;
use Illuminate\Support\Facades\Log;
use Bits\Package\Policies\BasePolicy;


class AdminActivityPolicy extends BasePolicy
{
    public function viewAny(User $user, AdminActivity $adminActivity = null)
    {

        return $user->hasPermission('view_admin_activities');
    }

    public function view(User $user, AdminActivity $adminActivity)
    {
        // 2️⃣ Normal user: only if they don’t already have a profile
        $existingProfile = $user->profile();
        if ($user->role->slug === 'user' && is_object($existingProfile) && $existingProfile->first()->id == $adminActivity->profile_id) {
            return true;
        }
        return $user->hasPermission('view_admin_activities');
    }


    public function create(User $user)
    {

        if ($user->role->slug === 'user' && !$user->is_profile_complete) {
            return true;
        }

        return $user->hasPermission('create_admin_activities');
    }

    public function update(User $user, AdminActivity $adminActivity)
    {
        // 2️⃣ Normal user: only if they don’t already have a profile
        $existingProfile = $user->profile();

        if ($user->role->slug === 'user' && is_object($existingProfile) && $existingProfile->first()->id == $adminActivity->profile_id) {
            return true;
        }
        return $user->hasPermission('update_admin_activities');
    }

    public function delete(User $user, AdminActivity $adminActivity)
    {
        // 2️⃣ Normal user: only if they don’t already have a profile
        $existingProfile = $user->profile();
        if ($user->role->slug === 'user' && is_object($existingProfile) && $existingProfile->first()->id == $adminActivity->profile_id) {
            return true;
        }
        return $user->hasPermission('delete_admin_activities');
    }

    public function bulkDelete(User $user)
    {
        return $user->hasPermission('bulk_delete_admin_activities');
    }
}