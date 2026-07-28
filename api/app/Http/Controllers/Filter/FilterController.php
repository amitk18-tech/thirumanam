<?php

namespace App\Http\Controllers\Filter;

use Bits\Package\Repositories\BaseRepository;
use Bits\Package\Services\BaseService;
use Bits\Package\Controllers\BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\User;
use Bits\Package\Responses\ApiResponse;
use App\Models\Member;

class FilterController extends BaseController
{
    public function __construct()
    {
        $this->policyModel = Profile::class;

        // Middleware for service + auth logging
        $this->middleware(function ($request, $next) {

            $authUser = Auth::user();

            Log::info('FOLLOW_ACTION: Authenticated User', [
                'user_id' => $authUser?->id,
                'role' => $authUser?->role,
                'permissions' => $authUser?->permissions ?? [],
            ]);

            $this->service = new BaseService(
                new BaseRepository(new Profile(), null)
            );

            return $next($request);
        });

        // Validation rules
        $this->storeRules = [
            'follower_id' => 'required|exists:users,id',
            'following_id' => 'required|exists:users,id|different:follower_id',
        ];

        $this->updateRules = []; // Not needed for follow
    }

    public function filter(Request $request)
    {
        $status = $request->status;

        // Define the columns you want to return
        $columns = [
            'id',
            'profile_id',
            'member_id',
            'profile_photo',
            'user_name',
            'profile_reported',
            'membership_type',
            'marital_status',
            'profiles_used',
            'created_at',
            'membership_status',
        ];

        $query = Profile::with([
            'user',
            'user.role',
            'familyDetail',
            'partnerPreference',
            'photos',
            'member',
            'horoscopeBoxes',
        ]);

        switch ($status) {

            case 'blockedMembers':
                $query->whereHas('member', function ($memberQuery) {
                    $memberQuery->where('blocked_by_admin', true);
                });
                break;

            case 'pendingRenewal':
                $query->where('membership_expired', true)
                    ->where('status', 'inactive');
                break;

            case 'verifiedMembers':
                $query->whereHas('user', function ($userQuery) {
                    $userQuery->where('is_verified', true);
                });
                break;

            case 'offlineRegisters':
                $query->where('registration_mode', 'offline')
                      ->whereIn('membership_type', ['yellow', 'blue', 'green']);
                break;

            case 'onlineRegisters':
                $query->where('registration_mode', 'online')
                      ->whereIn('membership_type', ['default', 'essential', 'classic', 'prime']);
                break;

            case 'incompleteProfiles':
                // Filter users where profile is NOT complete
                $query->whereHas('user', function ($userQuery) {
                    $userQuery->where('is_profile_complete', false);
                });
                break;

            case 'membersWithoutProfilePicture':
                $query->whereNull('profile_photo');
                break;

            case 'reportedMembers':
                $query->whereHas('member', function ($m) {
                    $m->where('is_reported', true);
                });
                break;

            case 'deactivatedMembers':
                $query->whereHas('member', function ($m) {
                    $m->where('is_deactivated', true);
                });
                break;

            case 'matchedMembers':
                $query->whereHas('member', function ($m) {
                    $m->where('is_matched', true);
                });
                break;


            default:
                return ApiResponse::error('Invalid filter type', 400);
        }

        // Filter by member_no, user_name, phone
        if ($request->has('member_no') && !empty($request->member_no)) {
            $memberNo = $request->member_no;
            $query->whereHas('member', function ($q) use ($memberNo) {
                $q->where('member_no', 'like', "%{$memberNo}%");
            });
        }

        if ($request->has('user_name') && !empty($request->user_name)) {
            $userName = $request->user_name;
            $query->whereHas('user', function ($q) use ($userName) {
                $q->where('name', 'like', "%{$userName}%");
            });
        }

        if ($request->has('phone') && !empty($request->phone)) {
            $phone = $request->phone;
            $query->whereHas('user', function ($q) use ($phone) {
                $q->where('phone', 'like', "%{$phone}%");
            });
        }

        // Pagination
        $perPage = $request->input('per_page', 10);
        /** @var \Illuminate\Pagination\LengthAwarePaginator $profiles */
        $profiles = $query->paginate($perPage);

        // Map the members to only include the selected columns
        $data = collect($profiles->items())->map(function ($profile) {
            $member = $profile->member;

            return [
                // ✅ MEMBER DATA (PRIMARY)
                'id' => $member?->id,
                'membership_type' => $member?->profile->membership_type,
                'membership_status' => $member?->status,
                'profiles_used' => $member?->profiles_view_remaining ?? 0,
                'created_at' => $member?->created_at?->format('d-m-Y h:i A'),
                'phone' => $profile?->user->phone,
                'member_no' => $member?->member_no,

                // ✅ PROFILE DATA (SECONDARY)
                'profile_id' => $profile->id,
                'profile_photo' => $profile->profile_photo ?: (strtolower($profile->gender) === 'female' ? 'storage/default_image/default_female.jpg' : 'storage/default_image/default_male.jpg'),

                'marital_status' => $profile->marital_status,
                'profile_reported' => $profile->reported ?? false,

                'city' => $profile->city,
                'age' => $profile->age,

                'is_renewed' => $member?->isRenewed ?? false,
                // ✅ USER DATA
                'user_name' => $profile->user?->name ?? '',
            ];
        });


        return ApiResponse::success('Filtered members loaded.', [
            'current_page' => $profiles->currentPage(),
            'per_page' => $profiles->perPage(),
            'total' => $profiles->total(),
            'last_page' => $profiles->lastPage(),
            'data' => $data,
        ]);
    }

    /**
     * Generic store (if needed)
     */
}