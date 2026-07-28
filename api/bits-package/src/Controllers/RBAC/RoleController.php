<?php

namespace Bits\Package\Controllers\RBAC;

use Bits\Package\Controllers\BaseController;
use Bits\Package\Repositories\BaseRepository;
use Bits\Package\Services\BaseService;
use Bits\Package\Responses\ApiResponse;
use Illuminate\Http\Request;

class RoleController extends BaseController
{
    protected string $modelClass;

    public function __construct(string $modelClass)
    {
        $this->modelClass = $modelClass;
        $this->policyModel = $modelClass;

        parent::__construct();

        $this->service = new BaseService(
            new BaseRepository(new $modelClass())
        );

        $this->storeRules = [
            'name' => 'required|string|max:50',
            'slug' => 'required|string|max:50',
            'description' => 'nullable|string|max:255',
        ];

        $this->updateRules = [
            'name' => 'sometimes|required|string|max:50',
            'slug' => 'sometimes|required|string|max:50',
            'description' => 'nullable|string|max:255',
        ];
    }

    public function show($id, Request $request)
    {
        try {
            $this->authorize('view', $this->policyModel);

            // Fetch with permissions (standard RBAC behavior)
            $role = $this->service->get($id, ['permissions']);

            return ApiResponse::success('Role details loaded successfully', $role);
        } catch (\Throwable $e) {
            return ApiResponse::error('Failed to retrieve role', $e->getMessage(), 500);
        }
    }
}
