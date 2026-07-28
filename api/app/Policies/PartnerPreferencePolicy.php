<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PartnerPreference;
use Illuminate\Support\Facades\Log;
use Bits\Package\Policies\BasePolicy;

class PartnerPreferencePolicy extends BasePolicy
{
    public function viewAny(User $user, PartnerPreference $partnerPreference = null)
    {
        return $user->hasPermission('view_partner_preferences');
    }

    public function view(User $user, PartnerPreference $partnerPreference)
    {
        // 2️⃣ Normal user: only if they don’t already have a profile
        $existingProfile = $user->profile();
        if ($user->role->slug === 'user' && is_object($existingProfile) && $existingProfile->first()->id == $partnerPreference->profile_id) {
            return true;
        }
        return $user->hasPermission('view_partner_preferences');
    }


    public function create(User $user)
    {
        // 2️⃣ Normal user: only if they don’t already have a profile
        $existingProfile = $user->profile()->exists();

        if ($user->role->slug === 'user' && $existingProfile && !$user->is_profile_complete) {
            return true;
        }

        return $user->hasPermission('create_partner_preferences');
    }

    public function update(User $user, PartnerPreference $partnerPreference)
    {
        // 2️⃣ Normal user: only if they don’t already have a profile
        $existingProfile = $user->profile();

        if ($user->role->slug === 'user' && is_object($existingProfile) && $existingProfile->first()->id == $partnerPreference->profile_id) {
            return true;
        }
        return $user->hasPermission('update_partner_preferences');
    }

    public function delete(User $user, PartnerPreference $partnerPreference)
    {
        // 2️⃣ Normal user: only if they don’t already have a profile
        $existingProfile = $user->profile();
        if ($user->role->slug === 'user' && is_object($existingProfile) && $existingProfile->first()->id == $partnerPreference->profile_id) {
            return true;
        }
        return $user->hasPermission('delete_partner_preferences');
    }

    public function bulkDelete(User $user)
    {
        return $user->hasPermission('bulk_delete_partner_preferences');
    }
}