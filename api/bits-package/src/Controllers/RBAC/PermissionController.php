<?php

namespace Bits\Package\Controllers\RBAC;

use Bits\Package\Controllers\Controller;
use Bits\Package\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PermissionController extends Controller
{
    protected $service;
    protected string $policyModel;

    public function __construct($service, string $policyModel)
    {
        $this->service = $service;
        $this->policyModel = $policyModel;
    }

    public function index(Request $request)
    {
        try {
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
            $permission = $this->service->getPermissionById($id);
            if (!$permission) {
                return ApiResponse::error('Permission not found', null, 404);
            }
            $this->authorize('view', $permission);
            return ApiResponse::success('Permission loaded', $permission);
        } catch (\Throwable $e) {
            return ApiResponse::error('Error fetching permission', $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $this->authorize('create', $this->policyModel);

            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:permissions,name',
                'label' => 'required|string|max:255',
                'module' => 'nullable|string|max:255',
            ]);

            $permission = $this->service->createPermission($validated);

            return ApiResponse::success('Permission created successfully', $permission);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return ApiResponse::error('Validation failed', $e->errors(), 422);
        } catch (\Throwable $e) {
            Log::error('Error creating permission: ' . $e->getMessage());
            return ApiResponse::error('Error creating permission', $e->getMessage());
        }
    }
}
