<?php

namespace App\Http\Controllers\Rbac;

use Bits\Package\Repositories\BaseRepository;
use Bits\Package\Services\BaseService;
use Bits\Package\Controllers\BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Bits\Package\Responses\ApiResponse;
use Illuminate\Http\Request;


class UserController extends BaseController
{
    public function __construct()
    {
        $this->policyModel = User::class;

        $this->middleware(function ($request, $next) {
            $authUser = Auth::user();

            Log::info('USER: Authenticated User', [
                'user_id' => $authUser?->id,
                'role' => $authUser?->role,
                'permissions' => $authUser?->permissions ?? [],
            ]);

            // 🚨 Notice: No tenantId passed here
            $this->service = new BaseService(
                new BaseRepository(new User(), null) // pass null since users table has no tenant_id
            );

            return $next($request);
        });

        // Validation rules for creating a user
        $this->storeRules = [
            'name' => 'nullable|string|max:255',
            'email' => 'required|email|max:100',
            'phone' => 'required|string|max:15|unique:users,phone',
            'password' => 'required|string|min:8',
            'role_id' => 'nullable|exists:roles,id',
            'email_verified' => 'nullable|boolean',
            'phone_verified' => 'nullable|boolean',
            'status' => 'in:active,suspended,deleted',
        ];

        // Validation rules for updating a user
        $this->updateRules = [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|max:100',
            'phone' => 'sometimes|required|string|max:15',
            'password' => 'sometimes|nullable|string|min:8',
            'role_id' => 'nullable|exists:roles,id',
            'email_verified' => 'nullable|boolean',
            'phone_verified' => 'nullable|boolean',
            'status' => 'in:active,suspended,deleted',
        ];
    }

    public function index(Request $request)
    {
        try {
            Log::info('ACTION: Fetching user list', [
                'user_id' => Auth::id(),
                'filters' => $request->all(),
            ]);

            $query = User::with('role');

            // Filtering by ID
            if ($request->has('id') && !empty($request->id)) {
                $query->where('id', $request->id);
            }

            // Filtering by Name
            if ($request->has('name') && !empty($request->name)) {
                $query->where('name', 'like', '%' . $request->name . '%');
            }

            // Filtering by Email
            if ($request->has('email') && !empty($request->email)) {
                $query->where('email', 'like', '%' . $request->email . '%');
            }

            // Filtering by Phone
            if ($request->has('phone') && !empty($request->phone)) {
                $query->where('phone', 'like', '%' . $request->phone . '%');
            }

            // Filtering by Role Name
            if ($request->has('role_name') && !empty($request->role_name)) {
                $roleName = $request->role_name;
                $query->whereHas('role', function ($q) use ($roleName) {
                    $q->where('name', 'like', '%' . $roleName . '%');
                });
            }

            // Filtering by Status
            if ($request->has('status') && !empty($request->status)) {
                $status = $request->status;
                if ($status === 'active') {
                    $query->where('is_active', true);
                } elseif ($status === 'suspended') {
                    $query->where('is_active', false);
                }
            }

            // Pagination
            $perPage = $request->input('per_page', 10);
            $users = $query->paginate($perPage);

            // flatten role fields into user
            $data = collect($users->items())->map(function ($user) {
                return array_merge(
                    $user->toArray(),
                    [
                        'role_name' => $user->role?->name ?? 'N/A',
                        'role_description' => $user->role?->description,
                        'role_slug' => $user->role?->slug,
                        'status' => $user->is_active ? 'active' : 'suspended',
                        'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                    ]
                );
            });

            return ApiResponse::success('Fetched successfully', [
                'current_page' => $users->currentPage(),
                'per_page' => $users->perPage(),
                'total' => $users->total(),
                'last_page' => $users->lastPage(),
                'data' => $data,
            ]);
        } catch (\Throwable $e) {
            return ApiResponse::error('Failed to fetch users', $e->getMessage(), 500);
        }
    }


    public function show($id, Request $request)
    {
        try {
            Log::info('ACTION: Viewing record', [
                'user_id' => Auth::id(),
                'tenant_id' => $this->policyModel,
                'record_id' => $id
            ]);

            $data = $this->service->get(
                $id,
                array_merge($request->get('with', []), ['role']) // Eager load role relationship
            );

            $this->authorize('view', $data);

            return ApiResponse::success('Record found', $data);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return ApiResponse::error('Unauthorized', $e->getMessage(), 403);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return ApiResponse::error('Record not found', $e->getMessage(), 404);
        } catch (\Throwable $e) {
            return ApiResponse::error('Failed to retrieve record', $e->getMessage(), 500);
        }
    }


    /**
     * Override store to hash password before saving
     */
    public function store(Request $request)
    {
        try {
            $data = $this->validate($request, $this->storeRules);

            // hash password
            $data['password'] = Hash::make($data['password']);

            $user = $this->service->create($data);

            return ApiResponse::success('User created successfully.', $user);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return ApiResponse::error('Validation failed', $e->errors(), 422);
        } catch (\Throwable $e) {
            return ApiResponse::error('Failed to create user', $e->getMessage(), 500);
        }
    }

    /**
     * Override update to hash password if present
     */
    public function update(Request $request, $id)
    {
        try {
            // 🔥 1. If password is empty string, remove it
            if ($request->has('password') && $request->password === '') {
                $request->request->remove('password');
            }

            $data = $this->validate($request, $this->updateRules);

            // 🔥 2. If password is null, REMOVE it (CRITICAL)
            if (!isset($data['password']) || $data['password'] === null) {
                unset($data['password']);
            } else {
                // hash only when real password exists
                $data['password'] = Hash::make($data['password']);
            }

            $user = $this->service->update($id, $data);

            return ApiResponse::success('User updated successfully.', $user);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return ApiResponse::error('Validation failed', $e->errors(), 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return ApiResponse::error('User not found', $e->getMessage(), 404);
        } catch (\Throwable $e) {
            return ApiResponse::error('Failed to update user', $e->getMessage(), 500);
        }
    }

    public function destroy($id)
    {
        try {
            Log::info('ACTION: Deleting user', [
                'user_id' => Auth::id(),
                'record_id' => $id
            ]);

            $deleted = $this->service->delete($id);

            return ApiResponse::success('User deleted successfully.', $deleted);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return ApiResponse::error('User not found', $e->getMessage(), 404);
        } catch (\Throwable $e) {
            return ApiResponse::error('Failed to delete user', $e->getMessage(), 500);
        }
    }
}
