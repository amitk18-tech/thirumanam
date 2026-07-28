<?php

namespace Bits\Package\Traits;

use Bits\Package\Models\Role;

trait HasRoles
{
    /**
     * Relationship to the user's single role.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Check if the user has a specific role by name.
     */
    public function hasRole(string $roleName): bool
    {
        return $this->role?->name === $roleName;
    }

    /**
     * Assign a role to the user.
     */
    public function assignRole(string|Role $role): void
    {
        $role = $role instanceof Role ? $role : Role::where('name', $role)->firstOrFail();
        $this->role()->associate($role);
        $this->save();
    }

    /**
     * Remove the role from the user.
     */
    public function removeRole(): void
    {
        $this->role()->dissociate();
        $this->save();
    }

    /**
     * Check if the user has a specific permission.
     */
    public function hasPermission(string $permissionName): bool
    {
        if (!$this->role) {
            return false;
        }

        return $this->role->permissions()->where('name', $permissionName)->exists();
    }

    /**
     * Get all permissions for the user.
     */
    public function getPermissions(): array
    {
        if (!$this->role) {
            return [];
        }

        return $this->role->permissions()->pluck('name')->toArray();
    }
}