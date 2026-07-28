<?php

namespace Database\Seeders\dbseeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $staffRoleId = 3;
        $userRoleId = 4;

        $timestamp = now();

        // Get all permissions
        $permissions = DB::table('permissions')->get();

        $staffPermissions = [];
        $userPermissions = [];

        foreach ($permissions as $permission) {
            // Staff gets everything except role and user management
            if (
                !str_contains($permission->module, 'role') &&
                !str_contains($permission->module, 'user') &&
                str_starts_with($permission->name, 'view_') // only view permissions
            ) {
                $staffPermissions[] = [
                    'role_id' => $staffRoleId,
                    'permission_id' => $permission->id,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ];
            }


            // User gets only view permissions for core modules (products, sales, etc.)
            if (
                str_starts_with($permission->name, 'view_') &&
                in_array($permission->module, [
                    'product',
                    'sale',
                    'purchase_invoice',
                    'purchase_order',
                    'stock_adjustment',
                    'stock_batch',
                    'membership'
                ])
            ) {
                $userPermissions[] = [
                    'role_id' => $userRoleId,
                    'permission_id' => $permission->id,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ];
            }
        }

        // Insert into role_permissions table
        DB::table('role_permissions')->insert(array_merge(
            $staffPermissions,
            $userPermissions
        ));
    }
}