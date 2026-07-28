<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\Log;
use Bits\Package\Policies\BasePolicy;

class MessagePolicy extends BasePolicy
{
    public function viewAny(User $user, Message $message = null)
    {
        Log::info('Checking viewAny permission for Message', ['user_id' => $user->id, 'permission' => $user->getPermissions()]);
        return $user->hasPermission('view_messages');
    }

    public function view(User $user, Message $message)
    {
        return $user->hasPermission('view_messages');
    }


    public function create(User $user)
    {
        return $user->hasPermission('create_messages');
    }

    public function update(User $user, Message $message)
    {
        return $user->hasPermission('update_messages');
    }

    public function delete(User $user, Message $message)
    {
        return $user->hasPermission('delete_messages');
    }

    public function bulkDelete(User $user)
    {
        return $user->hasPermission('bulk_delete_messages');
    }
}