<?php

namespace App\Http\Controllers\Profile;


use Bits\Package\Repositories\BaseRepository;
use Bits\Package\Services\BaseService;
use Bits\Package\Controllers\BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Profile;
use App\Models\Membership;
use App\Models\Member;
use App\Models\ProfileVerificationLog;
use App\Models\HoroscopeBox;
use Illuminate\Http\Request;
use Bits\Package\Responses\ApiResponse;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class PublicController extends BaseController
{
    protected BaseService $membershipService;
    protected BaseService $membersService;

    protected BaseService $userService;

    protected BaseService $profileService;

    public function __construct()
    {
        $this->policyModel = Member::class;

        // Initialize all services here directly
        $this->membersService = new BaseService(
            new BaseRepository(new Member(), null)
        );

        $this->profileService = new BaseService(
            new BaseRepository(new Profile(), null)
        );

        $this->membershipService = new BaseService(
            new BaseRepository(new Membership(), null)
        );

        $this->userService = new BaseService(
            new BaseRepository(new User(), null)
        );

        // IMPORTANT FIX 🔥
        $this->service = $this->membersService;

        // Middleware for logging authenticated user
        $this->middleware(function ($request, $next) {
            $authUser = Auth::user();

            Log::info('PROFILE: Authenticated User', [
                'user_id' => $authUser?->id,
                'role' => $authUser?->role,
                'permissions' => $authUser?->permissions,
            ]);

            return $next($request);
        });
    }

    public function index(Request $request)
    {
        try {

            $filters = [];

            // ❌ matched members hide pannum
            $filters['is_matched'] = false;

            if ($request->has('registration_mode')) {
                $filters['registration_mode'] = $request->registration_mode;
            }

            if ($request->boolean('no_photo')) {
                $filters['profile_photo'] = null;
            }

            $profiles = $this->service->list(
                $filters,
                $request->get('joins', []),
                $request->get('with', [
                    'profile',
                    'profile.user',
                    'membership'
                ])
            );

            $data = $profiles->map(function ($p) {
                return [
                    'id' => $p->id,
                    'name' => $p->profile->user->name ?? null,
                    'profile_gender' => $p->profile->gender ?? null,
                    'membership_slug' => $p->membership->slug ?? null,
                    'member_no' => $p->member_no ?? null,
                    'profile_marital_status' => $p->profile->marital_status ?? null,
                    'profiles_used' => $p->profiles_used ?? 0,
                    'created_at' => $p->created_at->format('Y-m-d'),
                    'status' => $p->status,
                ];
            });

            return ApiResponse::success('Fetched successfully', $data);
        } catch (\Throwable $e) {
            return ApiResponse::error('Failed to fetch', $e->getMessage(), 500);
        }
    }
}