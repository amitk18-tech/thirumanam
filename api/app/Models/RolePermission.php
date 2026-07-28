<?php

namespace App\Models;

use Bits\Package\Models\RolePermission as BaseRolePermission;

class RolePermission extends BaseRolePermission
{

    protected $fillable = [
    ];

    public function __construct(array $attributes = [])
    {
        // Merge BaseUser fillable dynamically
        $this->fillable = array_merge(
            $this->fillable, // current class fields
            parent::$fillable ?? [] // only if defined as static, otherwise use parent instance
        );

        parent::__construct($attributes);
    }
}