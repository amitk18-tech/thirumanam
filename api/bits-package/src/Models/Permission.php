<?php

namespace Bits\Package\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public bool $isTenantScoped = false;
    protected $fillable = ['name', 'label', 'module'];

    public function roles()
    {
        return $this->belongsToMany(
            Role::class,
            'role_permissions',
            'permission_id',
            'role_id'
        )->withTimestamps();
    }
}