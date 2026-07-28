<?php

namespace App\Http\Controllers\Rbac;

use Bits\Package\Repositories\BaseRepository;
use Bits\Package\Services\BaseService;
use Bits\Package\Controllers\BaseController;
use Bits\Package\Responses\ApiResponse;

use App\Models\RolePermission;
use App\Models\Role;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class RolePermissionController extends BaseController
{
    public function __construct()
    {
        $this->policyModel = RolePermission::class;

        $this->middleware(function ($request, $next) {
            $user = Auth::user();

            Log::info('PRODUCT: User ID: ' . $user?->id, ['permissions' => $user?->permissions]);
            $this->service = new BaseService(
                new BaseRepository(new RolePermission())
            );

            return $next($request);
        });

        $this->storeRules = [
            'role_id' => 'required|exists:roles,id',
            'permission_id' => 'required|exists:permissions,id'
            // Add other fields as needed
        ];

        $this->updateRules = [
            'role_id' => 'sometimes|required|exists:roles,id',
            'permission_id' => 'sometimes|required|exists:permissions,id'
        ];
    }

    public function store(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permission_ids' => 'required|array',
            'permission_ids.*' => 'exists:permissions,id',
        ]);

        $role = Role::findOrFail($request->role_id);

        // Only attach new permissions, don't remove existing
        $role->permissions()->syncWithoutDetaching($request->permission_ids);

        return ApiResponse::success(
            'Permissions created successfully',
            $role->permissions()->get()
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'permission_ids' => 'required|array',
            'permission_ids.*' => 'exists:permissions,id',
        ]);

        $role = Role::findOrFail($id);

        // Replace existing permissions with the new ones
        $role->permissions()->sync($request->permission_ids);

        return ApiResponse::success(
            'Permissions updated successfully',
            $role->permissions()->get()
        );
    }

    // in RolePermissionController
    public function show($id, Request $request)
    {
        $role = Role::with('permissions')->findOrFail($id);

        return ApiResponse::success('Role permissions loaded', $role->permissions);
    }
}