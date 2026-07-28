<?php

namespace App\Http\Controllers\Rbac;

use Bits\Package\Repositories\BaseRepository;
use Bits\Package\Services\BaseService;
use Bits\Package\Controllers\BaseController;
use Bits\Package\Responses\ApiResponse;

use App\Models\Role;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RoleController extends BaseController
{
    public function __construct()
    {
        $this->policyModel = Role::class;

        $this->middleware(function ($request, $next) {
            $user = Auth::user();

            Log::info('ROLE: User ID: ' . $user?->id, ['permissions' => $user?->permissions]);
            $this->service = new BaseService(
                new BaseRepository(new Role())
            );

            return $next($request);
        });

        // ✅ Add proper validation rules
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

    // ✅ Custom: Join with categories and eager load
    public function withCategory(Request $request)
    {
        $joins = [
            ['categories', 'products.category_id', '=', 'categories.id']
        ];

        $with = ['category'];
        $filters = $request->get('filters', []);

        try {
            return ApiResponse::success('Products with category loaded', $this->service->list($filters, $joins, $with));
        } catch (\Throwable $e) {
            return ApiResponse::error('Error fetching with category', $e->getMessage());
        }
    }

    // ✅ Custom: Only in-stock products
    public function inStock(Request $request)
    {
        $filters = [
            'stock' => ['>', 0]
        ];

        try {
            return ApiResponse::success('In-stock products loaded', $this->service->list($filters));
        } catch (\Throwable $e) {
            return ApiResponse::error('Error fetching in-stock products', $e->getMessage());
        }
    }

    // ✅ Custom: Search by name
    public function search(Request $request)
    {
        $search = $request->get('q');
        $filters = [];


        if ($search) {
            $filters['product_name'] = ['like', "%{$search}%"];
        }

        try {
            return ApiResponse::success('Search results', $this->service->list($filters));
        } catch (\Throwable $e) {
            return ApiResponse::error('Error searching products', $e->getMessage());
        }
    }

    public function show($id, Request $request)
    {
        try {
            $this->authorize('view', $this->policyModel);

            // Fetch with permissions
            $role = $this->service->get($id, ['permissions']);

            return ApiResponse::success('Role with permissions loaded', $role);
        } catch (\Throwable $e) {
            return ApiResponse::error('Failed to retrieve role', $e->getMessage(), 500);
        }
    }
}