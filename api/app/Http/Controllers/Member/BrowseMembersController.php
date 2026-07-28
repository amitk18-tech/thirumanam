<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Member;
use App\Models\Profile;
use Bits\Package\Responses\ApiResponse;

class BrowseMembersController extends Controller
{
    public function index(Request $request)
    {
        try {
            $currentUser = Auth::user();

            if (!$currentUser) {
                return ApiResponse::error('Unauthenticated', 401);
            }

            $userRole = $currentUser->role?->name ?? 'user';
            $perPage  = (int) $request->get('per_page', 12);
            $page     = (int) $request->get('page', 1);
            $search   = trim((string) $request->get('search', ''));

            $query = Member::query()
                ->where('status', 'active')
                ->where('is_deleted', false)
                ->where('is_closed', 'no')
                ->where('blocked_by_admin', false)
                ->where('rejected_by_admin', false)
                ->where('is_deactivated', false)
                ->where('membership_expired', false)
                ->whereNull('deleted_at')
                ->where('member_no', '!=', 'Temporary');

            if (!in_array($userRole, ['admin', 'super admin'])) {
                $myProfile = $currentUser->profile;
                $myGender  = strtolower($myProfile?->gender ?? '');
                $opposite  = $myGender === 'male' ? 'female' : 'male';

                $query->whereHas('profile', function ($p) use ($opposite) {
                    $p->whereRaw('LOWER(gender) = ?', [$opposite]);
                });
            }

            if ($search !== '') {
                $query->where(function ($q) use ($search) {
                    $q->where('member_no', 'like', "%{$search}%")
                      ->orWhereHas('profile.user', function ($u) use ($search) {
                          $u->where('name', 'like', "%{$search}%");
                      });
                });
            }

            if ($request->filled('age_min') || $request->filled('age_max')) {
                $query->whereHas('profile', function ($p) use ($request) {
                    if ($request->filled('age_min')) {
                        $p->where('age', '>=', (int) $request->get('age_min'));
                    }
                    if ($request->filled('age_max')) {
                        $p->where('age', '<=', (int) $request->get('age_max'));
                    }
                });
            }

            if ($request->filled('marital_status')) {
                $query->whereHas('profile', function ($p) use ($request) {
                    $p->whereRaw('LOWER(marital_status) = ?', [strtolower($request->get('marital_status'))]);
                });
            }

            if ($request->filled('education')) {
                $query->whereHas('profile', function ($p) use ($request) {
                    $p->whereRaw('LOWER(education) = ?', [strtolower($request->get('education'))]);
                });
            }

            if ($request->filled('city')) {
                $query->whereHas('profile', function ($p) use ($request) {
                    $p->whereRaw('LOWER(city) like ?', ['%' . strtolower($request->get('city')) . '%']);
                });
            }

            $paginated = $query
                ->orderByRaw("CAST(REGEXP_REPLACE(member_no, '[^0-9]', '') AS UNSIGNED) DESC")
                ->with(['membership', 'profile.user', 'profile.photos'])
                ->paginate($perPage, ['*'], 'page', $page);

            $data = collect($paginated->items())->map(function ($m) {
                $profile = $m->profile;
                $gender  = strtolower($profile?->gender ?? '');
                return [
                    'id'             => $m->id,
                    'member_no'      => $m->member_no,
                    'profile_id'     => $profile?->id,
                    'name'           => $profile?->user?->name,
                    'age'            => $profile?->age,
                    'city'           => $profile?->city,
                    'gender'         => $profile?->gender,
                    'marital_status' => $profile?->marital_status,
                    'education'      => $profile?->education,
                    'occupation'     => $profile?->occupation,
                    'profile_photo'  => $profile?->profile_photo
                        ?: ($gender === 'female'
                            ? 'storage/default_image/default_female.jpg'
                            : 'storage/default_image/default_male.jpg'),
                    'membership_type' => $profile?->membership_type,
                'membership_slug' => $member->membership->slug ?? null,
                ];
            });

            return ApiResponse::success('Members fetched successfully.', [
                'current_page' => $paginated->currentPage(),
                'per_page'     => $paginated->perPage(),
                'total'        => $paginated->total(),
                'last_page'    => $paginated->lastPage(),
                'data'         => $data,
            ]);

        } catch (\Throwable $e) {
            Log::error('BrowseMembers index error', ['error' => $e->getMessage()]);
            return ApiResponse::error('Failed to fetch members', $e->getMessage(), 500);
        }
    }

    public function showMe(Request $request)
    {
        try {
            $currentUser = Auth::user();
            if (!$currentUser) {
                return ApiResponse::error('Unauthenticated', 401);
            }
            $member = Member::with([
                'membership',
                'profile.user',
                'profile.photos',
                'profile.familyDetail',
                'profile.partnerPreference',
                'profile.horoscopeBoxes',
            ])->whereHas('profile', function ($q) use ($currentUser) {
                $q->where('user_id', $currentUser->id);
            })->first();

            if (!$member) {
                return ApiResponse::error('Member not found', 404);
            }

            $profile = $member->profile;
            $gender  = strtolower($profile?->gender ?? '');

            return ApiResponse::success('Member fetched successfully.', [
                'id'             => $member->id,
                'member_no'      => $member->member_no,
                'profile_id'     => $profile?->id,
                'name'           => $profile?->user?->name,
                'age'            => $profile?->age,
                'gender'         => $profile?->gender,
                'dob'            => $profile?->date_of_birth,
                'marital_status' => $profile?->marital_status,
                'religion'       => $profile?->religion,
                'caste'          => $profile?->caste,
                'subcaste'       => $profile?->subcaste,
                'city'           => $profile?->city,
                'state'          => $profile?->state,
                'country'        => $profile?->country,
                'education'      => $profile?->education,
                'occupation'     => $profile?->occupation,
                'income'         => $profile?->income,
                'bio'            => $profile?->bio,
                'introduction'   => $profile?->introduction,
                'height'         => $profile?->height,
                'weight'         => $profile?->weight,
                'star'           => $profile?->star,
                'rasi'           => $profile?->rasi,
                'nakshatra'      => $profile?->nakshatra,
                'dosham'         => $profile?->dosham,
                'birth_time'     => $profile?->birth_time,
                'birth_place'    => $profile?->birth_place,
                'birth_city'     => $profile?->birth_city,
                'birth_state'    => $profile?->birth_state,
                'birth_country'  => $profile?->birth_country,
                'paksha'         => $profile?->paksha,
                'tithi'          => $profile?->tithi,
                'ganam'          => $profile?->ganam,
                'nadi'           => $profile?->nadi,
                'lakknam'        => $profile?->lakknam,
                'padam'          => $profile?->padam,
                'horoscope_matching' => $profile?->horoscope_matching,
                'directional_balance' => $profile?->directional_balance,
                'complexion'     => $profile?->complexion,
                'body_type'      => $profile?->body_type,
                'blood_group'    => $profile?->blood_group,
                'physical_status'=> $profile?->physical_status,
                'eye_color'      => $profile?->eye_color,
                'hair_color'     => $profile?->hair_color,
                'work_location'  => $profile?->work_location,
                'career_profile' => $profile?->career_profile,
                'study_details'  => $profile?->study_details,
                'earnings'       => $profile?->earnings,
                'income_amount'  => $profile?->income_amount,
                'mobile'         => $profile?->mobile,
                'alternate_number' => $profile?->alternate_number,
                'landline'       => $profile?->landline,
                'address'        => $profile?->address,
                'current_city'   => $profile?->current_city,
                'postal_code'    => $profile?->postal_code,
                'native_place'   => $profile?->native_place,
                'mother_tongue'  => $profile?->mother_tongue,
                'membership_type' => $profile?->membership_type,
                'membership_slug' => $member->membership->slug ?? null,
                'profile_photo'  => $profile?->profile_photo ?: ($gender === 'female' ? 'storage/default_image/default_female.jpg' : 'storage/default_image/default_male.jpg'),
                'photos'              => $profile?->photos ?? [],
                'interests_sent_count'       => DB::table('interests')->where('sender_profile_id', $profile?->id)->count(),
                'interests_received_count'    => DB::table('interests')->where('receiver_profile_id', $profile?->id)->count(),
                'shortlisted_profiles_count'  => DB::table('profile_actions')->where('from_profile_id', $profile?->id)->count(),
                'profiles_view_remaining'     => $member->profiles_view_remaining ?? 0,
                'profiles_view_allowed'       => $member->profiles_view_allowed ?? 0,
                'sent_interest_remaining'     => $member->sent_interest_remaining ?? 0,
                'sent_interest_allowed'       => $member->sent_interest_allowed ?? 0,
                'messages_sent_remaining'     => $member->messages_sent_remaining ?? 0,
                'messages_sent_allowed'       => $member->messages_sent_allowed ?? 0,
                'family'              => $profile?->familyDetail,
                'partner_preference'  => $profile?->partnerPreference,
                'horoscope_boxes'     => $profile?->horoscopeBoxes ?? [],
            ]);
        } catch (\Throwable $e) {
            Log::error('BrowseMembers showMe error', ['error' => $e->getMessage()]);
            return ApiResponse::error('Failed to fetch member', $e->getMessage(), 500);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $currentUser = Auth::user();

            if (!$currentUser) {
                return ApiResponse::error('Unauthenticated', 401);
            }

            $member = Member::with([
                'membership',
                'profile.user',
                'profile.photos',
                'profile.familyDetail',
                'profile.partnerPreference',
                'profile.horoscopeBoxes',
            ])->find($id);

            if (!$member) {
                return ApiResponse::error('Member not found', 404);
            }

            $profile = $member->profile;
            $gender  = strtolower($profile?->gender ?? '');

            $data = [
                'id'             => $member->id,
                'member_no'      => $member->member_no,
                'profile_id'     => $profile?->id,
                'name'           => $profile?->user?->name,
                'age'            => $profile?->age,
                'gender'         => $profile?->gender,
                'dob'            => $profile?->date_of_birth,
                'marital_status' => $profile?->marital_status,
                'religion'       => $profile?->religion,
                'caste'          => $profile?->caste,
                'subcaste'       => $profile?->subcaste,
                'city'           => $profile?->city,
                'state'          => $profile?->state,
                'country'        => $profile?->country,
                'education'      => $profile?->education,
                'occupation'     => $profile?->occupation,
                'income'         => $profile?->income,
                'bio'            => $profile?->bio,
                'introduction'   => $profile?->introduction,
                'height'         => $profile?->height,
                'weight'         => $profile?->weight,
                'star'           => $profile?->star,
                'rasi'           => $profile?->rasi,
                'nakshatra'      => $profile?->nakshatra,
                'dosham'         => $profile?->dosham,
                'birth_time'     => $profile?->birth_time,
                'birth_place'    => $profile?->birth_place,
                'birth_city'     => $profile?->birth_city,
                'birth_state'    => $profile?->birth_state,
                'birth_country'  => $profile?->birth_country,
                'paksha'         => $profile?->paksha,
                'tithi'          => $profile?->tithi,
                'ganam'          => $profile?->ganam,
                'nadi'           => $profile?->nadi,
                'lakknam'        => $profile?->lakknam,
                'padam'          => $profile?->padam,
                'horoscope_matching' => $profile?->horoscope_matching,
                'directional_balance' => $profile?->directional_balance,
                'complexion'     => $profile?->complexion,
                'body_type'      => $profile?->body_type,
                'blood_group'    => $profile?->blood_group,
                'physical_status'=> $profile?->physical_status,
                'eye_color'      => $profile?->eye_color,
                'hair_color'     => $profile?->hair_color,
                'work_location'  => $profile?->work_location,
                'career_profile' => $profile?->career_profile,
                'study_details'  => $profile?->study_details,
                'earnings'       => $profile?->earnings,
                'income_amount'  => $profile?->income_amount,
                'mobile'         => $profile?->mobile,
                'alternate_number' => $profile?->alternate_number,
                'landline'       => $profile?->landline,
                'address'        => $profile?->address,
                'current_city'   => $profile?->current_city,
                'postal_code'    => $profile?->postal_code,
                'native_place'   => $profile?->native_place,
                'mother_tongue'  => $profile?->mother_tongue,
                'membership_type' => $profile?->membership_type,
                'membership_slug' => $member->membership->slug ?? null,
                'profile_photo'  => $profile?->profile_photo
                    ?: ($gender === 'female'
                        ? 'storage/default_image/default_female.jpg'
                        : 'storage/default_image/default_male.jpg'),
                'photos'              => $profile?->photos ?? [],
                'interests_sent_count'       => DB::table('interests')->where('sender_profile_id', $profile?->id)->count(),
                'interests_received_count'    => DB::table('interests')->where('receiver_profile_id', $profile?->id)->count(),
                'shortlisted_profiles_count'  => DB::table('profile_actions')->where('from_profile_id', $profile?->id)->count(),
                'profiles_view_remaining'     => $member->profiles_view_remaining ?? 0,
                'profiles_view_allowed'       => $member->profiles_view_allowed ?? 0,
                'sent_interest_remaining'     => $member->sent_interest_remaining ?? 0,
                'sent_interest_allowed'       => $member->sent_interest_allowed ?? 0,
                'messages_sent_remaining'     => $member->messages_sent_remaining ?? 0,
                'messages_sent_allowed'       => $member->messages_sent_allowed ?? 0,
                'family'              => $profile?->familyDetail,
                'partner_preference'  => $profile?->partnerPreference,
                'horoscope_boxes'     => $profile?->horoscopeBoxes ?? [],
            ];

            return ApiResponse::success('Member fetched successfully.', $data);

        } catch (\Throwable $e) {
            Log::error('BrowseMembers show error', ['error' => $e->getMessage()]);
            return ApiResponse::error('Failed to fetch member', $e->getMessage(), 500);
        }
    }
}
