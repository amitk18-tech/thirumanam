<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Facades\Log;
use Bits\Package\Policies\BasePolicy;

class OverviewPolicy extends BasePolicy
{
    public function viewAny(User $user)
    {
        Log::info('Checking viewAny permission for Overview', ['user_id' => $user->id, 'tenant_id' => $user->tenant_id, 'permission' => $user->getPermissions()]);

        if ($user->role && $user->role->slug === 'super_admin') {
            return true;
        }

        return $user->hasPermission('view_overview');
    }
}