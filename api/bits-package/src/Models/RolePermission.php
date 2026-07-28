<?php

namespace Bits\Package\Models;

use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    public bool $isTenantScoped = false;
    protected $table = 'role_permissions';

    protected $fillable = [
        'role_id',
        'permission_id',
    ];

    // Relationships
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }
}