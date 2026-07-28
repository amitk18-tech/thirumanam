<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Photo;
use Illuminate\Support\Facades\Log;
use Bits\Package\Policies\BasePolicy;

class PhotoPolicy extends BasePolicy
{
    public function viewAny(User $user, Photo $photo = null)
    {
        return $user->hasPermission('view_photos');
    }

    public function view(User $user, Photo $photo)
    {
        // 2️⃣ Normal user: only if they don’t already have a profile
        $existingProfile = $user->profile();

        if ($user->role->slug === 'user' && is_object($existingProfile) && $existingProfile->first()->id == $photo->profile_id) {
            return true;
        }

        return $user->hasPermission('view_photos');
    }


    public function create(User $user)
    {
        // 2️⃣ Normal user: only if they don’t already have a profile
        $existingProfile = $user->profile()->exists();

        if ($user->role->slug === 'user' && $existingProfile && !$user->is_profile_complete) {
            return true;
        }

        return $user->hasPermission('create_photos');
    }

    public function update(User $user, Photo $photo)
    {
        // 2️⃣ Normal user: only if they don’t already have a profile
        $existingProfile = $user->profile();

        if ($user->role->slug === 'user' && is_object($existingProfile) && $existingProfile->first()->id == $photo->profile_id) {
            return true;
        }
        return $user->hasPermission('update_photos');
    }

    public function delete(User $user, Photo $photo)
    {
        // 2️⃣ Normal user: only if they don’t already have a profile
        $existingProfile = $user->profile();

        if ($user->role->slug === 'user' && is_object($existingProfile) && $existingProfile->first()->id == $photo->profile_id) {
            return true;
        }

        return $user->hasPermission('delete_photos');
    }

    public function bulkDelete(User $user)
    {
        return $user->hasPermission('bulk_delete_photos');
    }
}