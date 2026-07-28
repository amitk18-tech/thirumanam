<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Bits\Package\Policies\BasePolicy;

class RolePolicy extends BasePolicy
{
    public function viewAny(User $user)
    {
        Log::info('Checking viewAny permission for Roles', ['user_id' => $user->id, 'permission' => $user->getPermissions()]);
        return $user->hasPermission('view_roles');
    }

    public function view(User $user, Product $product)
    {
        return $user->hasPermission('view_roles');
    }

    public function create(User $user)
    {
        return $user->hasPermission('create_roles');
    }

    public function update(User $user, Product $product)
    {
        return $user->hasPermission('update_roles');
    }

    public function delete(User $user, Product $product)
    {
        return $user->hasPermission('delete_roles');
    }

    public function bulkDelete(User $user)
    {
        return $user->hasPermission('bulk_delete_roles');
    }
}