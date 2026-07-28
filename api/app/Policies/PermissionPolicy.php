<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\User;

use Illuminate\Support\Facades\Log;
use Bits\Package\Policies\BasePolicy;

class PermissionPolicy extends BasePolicy
{
    public function viewAny(User $user)
    {
        Log::info('Checking viewAny permission for Permissions', ['user_id' => $user->id, 'tenant_id' => $user->tenant_id, 'permission' => $user->getPermissions()]);
        return $user->hasPermission('view_permissions');
    }

    public function view(User $user, Permission $permission)
    {
        return $user->hasPermission('view_permissions');
    }

    public function create(User $user)
    {
        return $user->hasPermission('create_permissions');
    }

    public function update(User $user, Permission $permission)
    {
        return $user->hasPermission('update_permissions');
    }

    public function delete(User $user, Permission $permission)
    {
        return $user->hasPermission('delete_permissions');
    }
}