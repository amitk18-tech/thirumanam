<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;
use Bits\Package\Policies\BasePolicy;

class PaymentPolicy extends BasePolicy
{
    public function viewAny(User $user)
    {
        Log::info('PaymentPolicy@viewAny HIT', [
            'user_id' => $user->id,
            'permissions' => $user->getPermissions(),
        ]);

        return $user->hasPermission('view_payments');
    }

    public function view(User $user, Payment $payment)
    {
        return $user->hasPermission('view_payments');
    }

    public function create(User $user)
    {
        return $user->hasPermission('create_payments');
    }

    public function update(User $user, Payment $payment)
    {
        return $user->hasPermission('update_payments');
    }

    public function delete(User $user, Payment $payment)
    {
        return $user->hasPermission('delete_payments');
    }
}