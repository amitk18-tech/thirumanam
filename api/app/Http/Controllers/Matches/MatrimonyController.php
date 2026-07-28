<?php

namespace App\Http\Controllers\Matches;

use Illuminate\Http\Request;
use Bits\Package\Repositories\BaseRepository;
use Bits\Package\Services\BaseService;
use Bits\Package\Responses\ApiResponse;
use Bits\Package\Controllers\BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Profile;
use App\Models\Membership;

use App\Models\Member;
use App\Models\Payment;
use App\Policies\MatrimonyPolicy;
use App\Http\Controllers\Controller;

class MatrimonyController extends Controller
{

    protected $profileService;
    protected $gender;

    protected $policyModel;

    public function __construct()
    {
        $this->policyModel = Profile::class;

        $this->middleware(function ($request, $next) {
            $authUser = Auth::user();
            $this->gender = $authUser?->gender;
            Log::info('MATCH_ACTION: Authenticated User', [
                'user_id'     => $authUser?->id,
                'role'        => $authUser?->role,
                'permissions' => $authUser?->permissions ?? [],
            ]);

            // No tenant_id in this table
            $this->profileService = new BaseService(
                new BaseRepository(new Profile(), null)
            );

            return $next($request);
        });
    }


    // LISTING METHODS
    public function search(Request $request)
    {
        try {
            $user = Auth::user();

            // Get current user's profile
            $profile = $this->profileService->list(['user_id' => $user->id])->first();
            if (!$profile) {
                return ApiResponse::error('Profile not found for the authenticated user', 404);
            }

            if (!$profile->gender) {
                return ApiResponse::error('Gender not found for the profile', 400);
            }

            // Always default to opposite gender
            $oppositeGender = $profile->gender === 'male' ? 'female' : 'male';

            // Base filters
            $filters = ['gender' => $oppositeGender];

            // Optional filters from query params
            if ($request->filled('age_from') && $request->filled('age_to')) {
                $filters['age_between'] = [$request->age_from, $request->age_to];
            }

            if ($request->filled('education')) {
                $filters['education'] = $request->education;
            }

            if ($request->boolean('premium')) {
                $filters['is_premium'] = true;
            }

            if ($request->boolean('featured')) {
                $filters['is_featured'] = true;
            }

            if ($request->boolean('newmembers')) {
                $filters['created_at'] = ['>=', now()->subDays(30)]; // last 30 days
            }

            if ($request->boolean('recent')) {
                $filters['order_by'] = ['created_at' => 'desc'];
            }

            if ($request->boolean('online_now')) {
                $filters['last_seen'] = ['>=', now()->subMinutes(5)];
            }

            // TODO: implement geo filter (nearme)
            if ($request->filled('nearme')) {
                $filters['location_near'] = [
                    'lat' => $profile->latitude,
                    'lng' => $profile->longitude,
                    'radius' => $request->nearme ?? 50, // default 50 km
                ];
            }

            $with = ['photos', 'education', 'occupation', 'location', 'family', 'lifestyle'];
            $join = [];

            // Pass filters to service (service should parse special keys like age_between, order_by, location_near)
            $profiles = $this->profileService->list($filters, $join, $with);

            return ApiResponse::success('Profiles retrieved successfully', $profiles);
        } catch (\Exception $e) {
            Log::error('Error retrieving search results: ' . $e->getMessage());
            return ApiResponse::error('Unable to retrieve profiles');
        }
    }

    public function newMembers(Request $request)
    {
        try {
            $recentMembers = Member::where('status', 'active')
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();

            return ApiResponse::success('New members retrieved successfully', $recentMembers);
        } catch (\Exception $e) {
            Log::error('Error retrieving new members: ' . $e->getMessage());
            return ApiResponse::error('Unable to retrieve new members');
        }
    }

    public function matches(Request $request)
    {
        try {
            $userId = Auth::id();
            $matches = Member::where('id', '!=', $userId)
                ->where('status', 'active')
                ->get();

            return ApiResponse::success('Matches retrieved successfully', $matches);
        } catch (\Exception $e) {
            Log::error('Error retrieving matches: ' . $e->getMessage());
            return ApiResponse::error('Unable to retrieve matches');
        }
    }

    public function profileDetails(Request $request, $id)
    {
        try {
            $profile = Member::findOrFail($id);

            return ApiResponse::success('Profile retrieved successfully', $profile);
        } catch (\Exception $e) {
            Log::error('Error retrieving profile: ' . $e->getMessage());
            return ApiResponse::error('Unable to retrieve profile');
        }
    }
    public function whoLikedMe(Request $request)
    {
        try {
            $userId = Auth::id();
            $likedMembers = Member::whereHas('likes', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->where('status', 'active')->get();

            return ApiResponse::success('Liked members retrieved successfully', $likedMembers);
        } catch (\Exception $e) {
            Log::error('Error retrieving liked members: ' . $e->getMessage());
            return ApiResponse::error('Unable to retrieve liked members');
        }
    }

    public function whoShortlistedMe(Request $request)
    {
        try {
            $userId = Auth::id();
            $shortlistedMembers = Member::whereHas('shortlists', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->where('status', 'active')->get();

            return ApiResponse::success('Shortlisted members retrieved successfully', $shortlistedMembers);
        } catch (\Exception $e) {
            Log::error('Error retrieving shortlisted members: ' . $e->getMessage());
            return ApiResponse::error('Unable to retrieve shortlisted members');
        }
    }

    public function whoViewedMyProfile(Request $request)
    {
        try {
            $userId = Auth::id();
            $viewedMembers = Member::whereHas('views', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->where('status', 'active')->get();

            return ApiResponse::success('Viewed members retrieved successfully', $viewedMembers);
        } catch (\Exception $e) {
            Log::error('Error retrieving viewed members: ' . $e->getMessage());
            return ApiResponse::error('Unable to retrieve viewed members');
        }
    }

    public function whoMessagedMe(Request $request)
    {
        try {
            $userId = Auth::id();
            $messagedMembers = Member::whereHas('messages', function ($query) use ($userId) {
                $query->where('recipient_id', $userId);
            })->where('status', 'active')->get();

            return ApiResponse::success('Messaged members retrieved successfully', $messagedMembers);
        } catch (\Exception $e) {
            Log::error('Error retrieving messaged members: ' . $e->getMessage());
            return ApiResponse::error('Unable to retrieve messaged members');
        }
    }

    public function whoContactedMe(Request $request)
    {
        try {
            $userId = Auth::id();
            $contactedMembers = Member::whereHas('contacts', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->where('status', 'active')->get();

            return ApiResponse::success('Contacted members retrieved successfully', $contactedMembers);
        } catch (\Exception $e) {
            Log::error('Error retrieving contacted members: ' . $e->getMessage());
            return ApiResponse::error('Unable to retrieve contacted members');
        }
    }
}