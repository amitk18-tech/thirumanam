<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Membership;
use Illuminate\Support\Facades\Log;
use Bits\Package\Policies\BasePolicy;

class MembershipPolicy extends BasePolicy
{
    public function viewAny(User $user, Membership $membership = null)
    {
        Log::info('Checking viewAny permission for Membership', ['user_id' => $user->id, 'permission' => $user->getPermissions()]);
        return $user->hasPermission('view_memberships');
    }

    public function view(User $user, Membership $membership)
    {
        return $user->hasPermission('view_memberships');
    }

    public function create(User $user)
    {
        return $user->hasPermission('create_memberships');
    }

    public function update(User $user, Membership $membership)
    {
        return $user->hasPermission('update_memberships');
    }

    public function delete(User $user, Membership $membership)
    {
        return $user->hasPermission('delete_memberships');
    }

    public function bulkDelete(User $user)
    {
        return $user->hasPermission('bulk_delete_memberships');
    }
}