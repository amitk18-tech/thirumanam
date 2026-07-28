<?php

namespace App\Http\Controllers\Rbac;

use App\Models\User;
use App\Models\Role;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Bits\Package\Responses\ApiResponse; // Assuming this exists based on UserController

class StaffController extends UserController
{
    public function __construct()
    {
        parent::__construct();
        // Overrides might be needed for service/repository if using BaseController logic deeply
    }

    /**
     * List all staff members with user details
     */
    public function index(Request $request)
    {
        try {
            Log::info('ACTION: Fetching user list (staff screen)', [
                'user_id' => Auth::id(),
            ]);

            // Fetch users with role relation
            $users = User::with('role')->get();

            // Filter users (example: exclude 'user' role)
            $users = $users->filter(fn($user) => $user->role?->slug !== 'user');

            // Prepare response (flattened, only role_name included)
            $data = $users->map(function ($user) {
                return collect($user->toArray())
                    ->except([
                        'role_id',
                        'role',          // remove role object
                        'password',
                        'remember_token',
                        'created_at',
                        'updated_at',
                    ])
                    ->merge([
                        'role_name' => $user->role?->name, // only include role name
                        'role_id' => $user->role?->id, // only include role id
                    ])
                    ->toArray();
            })->values(); // reset keys to 0,1,2

            return ApiResponse::success('Fetched successfully', $data);
        } catch (\Throwable $e) {
            Log::error('Failed to fetch user list', [
                'error' => $e->getMessage(),
            ]);

            return ApiResponse::error('Failed to fetch users', $e->getMessage(), 500);
        }
    }

    /**
     * Store a new staff member (User + Staff)
     */
    public function store(Request $request)
    {
        // 1. Validate Input
        // Combine validation rules for User and Staff
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:100|unique:users,email', // Check uniqueness on users table
            'phone' => 'nullable|string|max:15',
            'password' => 'required|string|min:8',
            'status' => 'nullable|in:active,suspended',

            // Staff specific
            'joining_date' => 'nullable|date',
            'salary' => 'nullable|numeric',
            'address' => 'nullable|string',
            'designation' => 'nullable|string',
        ];

        try {
            $validatedData = $request->validate($rules);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return ApiResponse::error('Validation failed', $e->errors(), 422);
        }

        DB::beginTransaction();
        try {
            // 2. Find/Ensure 'staff' Role exists
            $staffRole = Role::where('slug', 'staff')->firstOrFail();

            // 3. Create User
            $userData = [
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'phone' => $validatedData['phone'] ?? null,
                'password' => Hash::make($validatedData['password']),
                'role_id' => $staffRole->id,
                'status' => $validatedData['status'] ?? 'active',
                'email_verified' => true, // Auto verify for staff?
            ];
            $user = User::create($userData);

            // 4. Create Staff linked to User
            $staffData = [
                'user_id' => $user->id,
                'joining_date' => $validatedData['joining_date'] ?? null,
                'salary' => $validatedData['salary'] ?? null,
                'address' => $validatedData['address'] ?? null,
                'designation' => $validatedData['designation'] ?? null,
            ];
            $staff = Staff::create($staffData);

            DB::commit();

            return ApiResponse::success('Staff created successfully.', $staff->load('user'));
        } catch (\Throwable $e) {
            DB::rollBack();
            return ApiResponse::error('Failed to create staff', $e->getMessage(), 500);
        }
    }

    /**
     * Show a specific staff member
     */
    public function show($id, Request $request)
    {
        try {
            $staff = Staff::with('user.role')->findOrFail($id);
            // Flatten for frontend
            $data = array_merge(
                $staff->user ? $staff->user->toArray() : [],
                $staff->toArray(),
                [
                    'id' => $staff->id, // Staff ID
                    'user_id' => $staff->user_id
                ]
            );
            return ApiResponse::success('Staff details', $data);
        } catch (\Throwable $e) {
            return ApiResponse::error('Staff not found', $e->getMessage(), 404);
        }
    }

    /**
     * Update Staff and User
     */
    public function update(Request $request, $id)
    {
        $staff = Staff::findOrFail($id);
        $user = $staff->user;

        // Validation - Note: email unique check might need to ignore current user
        $rules = [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|max:100|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:15',
            'password' => 'nullable|string|min:8', // Optional update
            'status' => 'nullable|in:active,suspended',

            'joining_date' => 'nullable|date',
            'salary' => 'nullable|numeric',
            'address' => 'nullable|string',
            'designation' => 'nullable|string',
        ];

        try {
            $validatedData = $request->validate($rules);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return ApiResponse::error('Validation failed', $e->errors(), 422);
        }

        DB::beginTransaction();
        try {
            // Update User
            $userUpdates = $request->only(['name', 'email', 'phone', 'status']);
            if (!empty($validatedData['password'])) {
                $userUpdates['password'] = Hash::make($validatedData['password']);
            }
            $user->update($userUpdates);

            // Update Staff
            $staffUpdates = $request->only(['joining_date', 'salary', 'address', 'designation']);
            $staff->update($staffUpdates);

            DB::commit();

            return ApiResponse::success('Staff updated successfully', $staff->load('user'));
        } catch (\Throwable $e) {
            DB::rollBack();
            return ApiResponse::error('Failed to update staff', $e->getMessage(), 500);
        }
    }

    /**
     * Remove Staff (and User)
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $staff = Staff::findOrFail($id);
            $user = $staff->user;

            // Delete Staff first (or User first if cascade handles it, but manual is safer for logic)
            $staff->delete();

            // Delete User? 
            // Usually if we delete a "Staff member", we remove their system access too.
            if ($user) {
                $user->delete();
            }

            DB::commit();
            return ApiResponse::success('Staff deleted successfully', null);
        } catch (\Throwable $e) {
            DB::rollBack();
            return ApiResponse::error('Failed to delete staff', $e->getMessage(), 500);
        }
    }
}
