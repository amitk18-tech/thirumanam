<?php

namespace Bits\Package\Controllers\RBAC;

use Bits\Package\Controllers\BaseController;
use Bits\Package\Repositories\BaseRepository;
use Bits\Package\Services\BaseService;
use Bits\Package\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RolePermissionController extends BaseController
{
    protected string $roleClass;
    protected string $rolePermissionClass;

    public function __construct(string $roleClass, string $rolePermissionClass)
    {
        $this->roleClass = $roleClass;
        $this->rolePermissionClass = $rolePermissionClass;
        $this->policyModel = $rolePermissionClass;

        parent::__construct();

        $this->service = new BaseService(
            new BaseRepository(new $rolePermissionClass())
        );
    }

    public function index(Request $request)
    {
        try {
            $this->authorize('viewAny', $this->policyModel);

            $filters = $request->get('filters', []);
            if ($request->has('role_id')) {
                $filters[] = ['role_id', '=', $request->role_id];
            }

            $with = array_merge($request->get('with', []), ['role', 'permission']);

            $data = $this->service->list(
                $filters,
                $request->get('joins', []),
                $with
            );

            $response = $data->map(function ($item) {
                return [
                    'id' => $item->id,
                    'role_id' => $item->role_id,
                    'permission_id' => $item->permission_id,
                    'role_name' => $item->role->name ?? null,
                    'permission_name' => $item->permission->name ?? null,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });

            return ApiResponse::success('Fetched successfully', $response);
        } catch (\Throwable $e) {
            return ApiResponse::error('Failed to fetch', $e->getMessage(), 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $this->authorize('create', $this->policyModel);
            $request->validate([
                'role_id' => 'required|exists:roles,id',
                'permission_ids' => 'present|array',
                'permission_ids.*' => 'exists:permissions,id',
            ]);

            $role = ($this->roleClass)::findOrFail($request->role_id);
            $tenantId = Auth::user()?->tenant_id;

            $syncData = [];
            foreach ($request->permission_ids as $id) {
                if ($tenantId) {
                    $syncData[$id] = ['tenant_id' => $tenantId];
                } else {
                    $syncData[] = $id;
                }
            }

            $role->permissions()->syncWithoutDetaching($syncData);

            return ApiResponse::success(
                'Permissions created successfully',
                $role->permissions()->get()
            );
        } catch (\Illuminate\Validation\ValidationException $e) {
            return ApiResponse::error('Validation failed', $e->errors(), 422);
        } catch (\Throwable $e) {
            return ApiResponse::error('Error creating permissions', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'permission_ids' => 'present|array',
                'permission_ids.*' => 'exists:permissions,id',
            ]);

            $role = ($this->roleClass)::findOrFail($id);
            $this->authorize('update', $role);
            $tenantId = Auth::user()?->tenant_id;

            $syncData = [];
            foreach ($request->permission_ids as $pid) {
                if ($tenantId) {
                    $syncData[$pid] = ['tenant_id' => $tenantId];
                } else {
                    $syncData[] = $pid;
                }
            }

            $role->permissions()->sync($syncData);

            return ApiResponse::success(
                'Permissions updated successfully',
                $role->permissions()->get()
            );
        } catch (\Illuminate\Validation\ValidationException $e) {
            return ApiResponse::error('Validation failed', $e->errors(), 422);
        } catch (\Throwable $e) {
            return ApiResponse::error('Error updating permissions', $e->getMessage());
        }
    }

    public function show($id, Request $request)
    {
        try {
            $role = ($this->roleClass)::with('permissions')->findOrFail($id);
            $this->authorize('view', $role);

            return ApiResponse::success('Role permissions loaded', $role->permissions);
        } catch (\Throwable $e) {
            return ApiResponse::error('Error loading role permissions', $e->getMessage());
        }
    }
}
