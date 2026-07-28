<?php

namespace App\Http\Controllers\User;

use Bits\Package\Repositories\BaseRepository;
use Bits\Package\Services\BaseService;
use Bits\Package\Controllers\BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
use App\Models\Membership;
use App\Models\Member;
use PhpParser\Node\Expr\Print_;
use Bits\Package\Responses\ApiResponse;

class UserController extends BaseController
{

    protected BaseService $membershipService;
    protected BaseService $membersService;

    public function __construct()
    {
        $this->policyModel = User::class;

        $this->middleware(function ($request, $next) {
            $authUser = Auth::user();
            $this->service = new BaseService(
                new BaseRepository(new User(), null)
            );

            $this->membershipService = new BaseService(
                new BaseRepository(new Membership(), null),
            );

            $this->membersService = new BaseService(
                new BaseRepository(new Member(), null),
            );


            return $next($request);
        });

        // Validation rules for creating a user along with profile
        $this->storeRules = [

            /* ---------------------- USER FIELDS ---------------------- */
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'phone'         => 'required|string|unique:users,phone',
            'password'      => 'required|string|min:6|confirmed',
            'role_id'       => 'nullable|exists:roles,id',


        ];

        $this->updateRules = [

            // User fields
            'name'          => 'nullable|string|max:255',
            'email'         => 'nullable|email|unique:users,email',
            'phone'         => 'nullable|string|unique:users,phone',
            'password'      => 'nullable|string|min:6|confirmed',
            'role_id'       => 'nullable|exists:roles,id',

        ];
    }


    public function index(Request $request)
    {
        try {
            $users = $this->service->list();
            return ApiResponse::success('Users retrieved successfully', $users);
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to retrieve users', 500, $e->getMessage());
        }
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'phone'     => 'required|string|unique:users,phone',
            'password'  => 'required|string|min:6|confirmed',
            'role_id'   => 'nullable|exists:roles,id',
        ]);

        try {
            $user = $this->service->create([
                'name'      => $validated['name'],
                'email'     => $validated['email'],
                'phone'     => $validated['phone'],
                'role_id'   => $validated['role_id'] ?? null,
                'password'  => Hash::make($validated['password']),
            ]);

            return ApiResponse::success('User created successfully', $user);
        } catch (\Exception $e) {

            return ApiResponse::error('Failed to create user', 500, $e->getMessage());
        }
    }

    public function show($id, Request $request)
    {
        $user = User::find($id);

        if (!$user) {
            return ApiResponse::error('User not found', 404);
        }

        return ApiResponse::success('User retrieved successfully', $user);
    }
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 404);
        }

        $validated = $request->validate([
            'name'      => 'sometimes|string|max:255',
            'email'     => 'sometimes|email|unique:users,email,' . $id,
            'phone'     => 'sometimes|string|unique:users,phone,' . $id,
            'password'  => 'nullable|string|min:6|confirmed',
            'role_id'   => 'nullable|exists:roles,id',
        ]);

        try {
            $updateData = [];

            if ($request->filled('name'))     $updateData['name'] = $request->name;
            if ($request->filled('email'))    $updateData['email'] = $request->email;
            if ($request->filled('phone'))    $updateData['phone'] = $request->phone;
            if ($request->filled('role_id'))  $updateData['role_id'] = $request->role_id;
            if ($request->filled('password')) $updateData['password'] = Hash::make($request->password);

            $user->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'User updated successfully',
                'data' => $user,
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Update failed',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return ApiResponse::error('User not found', 404);
        }

        try {
            $user->delete();
            return ApiResponse::success('User deleted successfully');
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to delete user', 500, $e->getMessage());
        }
    }
}
