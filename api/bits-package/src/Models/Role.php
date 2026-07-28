<?php

namespace Bits\Package\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public bool $isTenantScoped = false;
    protected $fillable = ['name', 'description', 'slug'];

    /**
     * Permissions assigned to this role.
     */
    public function permissions()
    {
        return $this->belongsToMany(
            Permission::class,
            'role_permissions',
            'role_id',
            'permission_id'
        )->withTimestamps();
    }

    /**
     * Users having this role (one-to-many for single-role users).
     */
    public function users()
    {
        return $this->hasMany(
            config('auth.providers.users.model'), // usually App\Models\User
            'role_id'
        );
    }
}