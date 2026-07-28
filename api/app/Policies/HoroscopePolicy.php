<?php

namespace App\Policies;

use App\Models\User;
use App\Models\HoroscopeBox;
use Illuminate\Support\Facades\Log;
use Bits\Package\Policies\BasePolicy;

class HoroscopePolicy extends BasePolicy
{
    public function viewAny(User $user, HoroscopeBox $horoscopeBox = null)
    {
        Log::info('Checking viewAny permission for HoroscopeBox', ['user_id' => $user->id, 'permission' => $user->getPermissions()]);
        return $user->hasPermission('view_horoscope_boxes');
    }

    public function view(User $user, HoroscopeBox $horoscopeBox)
    {
        return $user->hasPermission('view_horoscope_boxes');
    }

    public function create(User $user)
    {
        return $user->hasPermission('create_horoscope_boxes');
    }

    public function update(User $user, HoroscopeBox $horoscopeBox)
    {
        return $user->hasPermission('update_horoscope_boxes');
    }

    public function delete(User $user, HoroscopeBox $horoscopeBox)
    {
        return $user->hasPermission('delete_horoscope_boxes');
    }

    public function bulkDelete(User $user)
    {
        return $user->hasPermission('bulk_delete_horoscope_boxes');
    }
}