<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Bits\Package\Policies\BasePolicy;

class UserPolicy extends BasePolicy
{
    public function viewAny(User $user)
    {
        Log::info('Checking viewAny permission for User', ['user_id' => $user->id, 'permission' => $user->getPermissions()]);
        return $user->hasPermission('view_users');
    }

    public function view(User $user, User $model)
    {
        return $user->hasPermission('view_users');
    }

    public function create(User $user)
    {
        return $user->hasPermission('create_users');
    }

    public function update(User $user, User $model)
    {
        return $user->hasPermission('update_users');
    }

    public function delete(User $user, User $model)
    {
        return $user->hasPermission('delete_users');
    }

    public function bulkDelete(User $user)
    {
        return $user->hasPermission('bulk_delete_users');
    }
}