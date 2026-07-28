<?php

namespace App\Policies;

use App\Models\User;
use App\Models\FamilyDetail;
use Illuminate\Support\Facades\Log;
use Bits\Package\Policies\BasePolicy;


class FamilyDetailPolicy extends BasePolicy
{
    public function viewAny(User $user, FamilyDetail $familyDetail = null)
    {

        return $user->hasPermission('view_family_details');
    }

    public function view(User $user, FamilyDetail $familyDetail)
    {
        // 2️⃣ Normal user: only if they don’t already have a profile
        $existingProfile = $user->profile();
        if ($user->role->slug === 'user' && is_object($existingProfile) && $existingProfile->first()->id == $familyDetail->profile_id) {
            return true;
        }
        return $user->hasPermission('view_family_details');
    }


    public function create(User $user)
    {

        if ($user->role->slug === 'user' && !$user->is_profile_complete) {
            return true;
        }

        return $user->hasPermission('create_family_details');
    }

    public function update(User $user, FamilyDetail $familyDetail)
    {
        // 2️⃣ Normal user: only if they don’t already have a profile
        $existingProfile = $user->profile();

        if ($user->role->slug === 'user' && is_object($existingProfile) && $existingProfile->first()->id == $familyDetail->profile_id) {
            return true;
        }
        return $user->hasPermission('update_family_details');
    }

    public function delete(User $user, FamilyDetail $familyDetail)
    {
        // 2️⃣ Normal user: only if they don’t already have a profile
        $existingProfile = $user->profile();
        if ($user->role->slug === 'user' && is_object($existingProfile) && $existingProfile->first()->id == $familyDetail->profile_id) {
            return true;
        }
        return $user->hasPermission('delete_family_details');
    }

    public function bulkDelete(User $user)
    {
        return $user->hasPermission('bulk_delete_family_details');
    }
}