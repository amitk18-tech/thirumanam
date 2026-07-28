<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MemberActivity;
use Illuminate\Support\Facades\Log;
use Bits\Package\Policies\BasePolicy;


class MemberActivityPolicy extends BasePolicy
{
    public function viewAny(User $user, MemberActivity $memberActivity = null)
    {

        return $user->hasPermission('view_member_activities');
    }

    public function view(User $user, MemberActivity $memberActivity)
    {
        // 2️⃣ Normal user: only if they don’t already have a profile
        $existingProfile = $user->profile();
        if ($user->role->slug === 'user' && is_object($existingProfile) && $existingProfile->first()->id == $memberActivity->profile_id) {
            return true;
        }
        return $user->hasPermission('view_member_activities');
    }


    public function create(User $user)
    {

        if ($user->role->slug === 'user' && !$user->is_profile_complete) {
            return true;
        }

        return $user->hasPermission('create_family_details');
    }

    public function update(User $user, MemberActivity $memberActivity)
    {
        // 2️⃣ Normal user: only if they don’t already have a profile
        $existingProfile = $user->profile();

        if ($user->role->slug === 'user' && is_object($existingProfile) && $existingProfile->first()->id == $memberActivity->profile_id) {
            return true;
        }
        return $user->hasPermission('update_member_activities');
    }

    public function delete(User $user, MemberActivity $memberActivity)
    {
        // 2️⃣ Normal user: only if they don’t already have a profile
        $existingProfile = $user->profile();
        if ($user->role->slug === 'user' && is_object($existingProfile) && $existingProfile->first()->id == $memberActivity->profile_id) {
            return true;
        }
        return $user->hasPermission('delete_member_activities');
    }

    public function bulkDelete(User $user)
    {
        return $user->hasPermission('bulk_delete_member_activities');
    }
}