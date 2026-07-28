<?php

namespace App\Http\Controllers\Rbac;

use App\Models\Permission;

use Illuminate\Http\Request;


use Bits\Package\Responses\ApiResponse;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Services\PermissionService;

use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    protected PermissionService $service;
    protected string $policyModel = Permission::class;


    public function __construct(PermissionService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return ApiResponse::error('Unauthorized', 'User not authenticated', 401);
            }
            $this->authorize('viewAny', $this->policyModel);
            $permissions = $this->service->getAllPermissions();
            return ApiResponse::success('Permissions loaded', $permissions);
        } catch (\Throwable $e) {
            return ApiResponse::error('Error fetching permissions', $e->getMessage());
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return ApiResponse::error('Unauthorized', 'User not authenticated', 401);
            }

            if (!$this->service->getPermissionById($id)) {
                return ApiResponse::error('Permission not found', 'No permission found with the given ID', 404);
            }

            $permission = $this->service->getPermissionById($id);
            $this->authorize('view', $permission);
            return ApiResponse::success('Permission loaded', $permission);
        } catch (\Throwable $e) {
            return ApiResponse::error('Error fetching permission', $e->getMessage());
        }
    }
}