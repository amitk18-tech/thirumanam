<?php

namespace App\Policies;

use App\Models\User;
use App\Models\RolePermission;
use Illuminate\Support\Facades\Log;
use Bits\Package\Policies\BasePolicy;

class RolePermissionPolicy extends BasePolicy
{
    public function viewAny(User $user)
    {
        Log::info('Checking viewAny permission for Role Permissions', ['user_id' => $user->id, 'permission' => $user->getPermissions()]);
        return $user->hasPermission('view_role_permissions');
    }

    public function view(User $user, RolePermission $rolePermission)
    {
        return $user->hasPermission('view_role_permissions');
    }

    public function create(User $user)
    {
        return $user->hasPermission('create_role_permissions');
    }

    public function update(User $user, RolePermission $rolePermission)
    {
        return $user->hasPermission('update_role_permissions');
    }

    public function delete(User $user, RolePermission $rolePermission)
    {
        return $user->hasPermission('delete_role_permissions');
    }

    public function bulkDelete(User $user)
    {
        return $user->hasPermission('bulk_delete_role_permissions');
    }
}