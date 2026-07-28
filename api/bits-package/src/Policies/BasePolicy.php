<?php

namespace Bits\Package\Policies;

use Bits\Package\Models\User;


class BasePolicy
{
    protected function getPermissionName($action, $modelClass)
    {
        // e.g. 'create_product' or 'delete_sales'
        $modelName = strtolower(class_basename($modelClass));
        return $action . '_' . $modelName;
    }

    public function before(User $user, $ability, $model = null)
    {
        // Skip override if the policy is for User model
        if ($model instanceof User) {
            return null;
        }

        $slug = $user->role->slug ?? null;
        $name = $user->role->name ?? null;

        if (in_array($slug, ['super_admin', 'admin'], true) || $name === 'Super Admin') {
            return true;
        }

        return null;
    }
}