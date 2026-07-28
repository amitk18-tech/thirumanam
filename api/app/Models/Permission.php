<?php

namespace App\Models;

use Bits\Package\Models\Permission as BasePermission;


class Permission extends BasePermission
{

    public function roles()
    {
        return parent::roles();
    }
}