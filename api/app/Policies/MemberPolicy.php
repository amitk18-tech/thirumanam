<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Member;
use Illuminate\Support\Facades\Log;
use Bits\Package\Policies\BasePolicy;

class MemberPolicy extends BasePolicy
{
    public function viewAny(User $user, Member $member = null)
    {
        Log::info('Checking viewAny permission for Member', ['user_id' => $user->id, 'permission' => $user->getPermissions()]);
        return $user->hasPermission('view_members');
    }

    public function view(User $user, Member $member)
    {
        return $user->hasPermission('view_members');
    }


    public function create(User $user)
    {
        return $user->hasPermission('create_members');
    }

    public function update(User $user, Member $member)
    {
        return $user->hasPermission('update_members');
    }

    public function delete(User $user, Member $member)
    {
        return $user->hasPermission('delete_members');
    }

    public function bulkDelete(User $user)
    {
        return $user->hasPermission('bulk_delete_members');
    }
}