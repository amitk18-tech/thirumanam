<?php

namespace App\Http\Controllers\Member;


use Bits\Package\Repositories\BaseRepository;
use Bits\Package\Services\BaseService;
use Bits\Package\Controllers\BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Profile;
use App\Models\Membership;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Bits\Package\Responses\ApiResponse;
use Illuminate\Support\Facades\DB;
use App\Models\DeletedMember;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\ProfileAction;
use App\Models\ProfileReport;
use App\Repositories\ProfileCompletionRepository;
use App\Services\ProfileCompletionService;
use Barryvdh\DomPDF\Facade\Pdf;


class MemberController extends BaseController
{
    protected BaseService $membershipService;
    protected BaseService $membersService;

    protected BaseService $userService;

    protected BaseService $profileService;
    protected ProfileCompletionService $profileCompletionService;

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

        $this->profileCompletionService = new ProfileCompletionService(
            new ProfileCompletionRepository()
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

        // Validation rules for creating a profile
        $this->storeRules = [
            'introduction' => 'nullable|string',
            // User Information
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email',
            'phone' => 'nullable|string|max:15',

            'password' => 'required|string|min:6',

            'registration_mode' => 'nullable|in:offline,online',


            // Profile Information
            'membership_type' => 'required|in:default,essential,classic,prime,green,blue,yellow',
            'profile_photo' => 'nullable|image|max:2048',
            'gender' => 'required|in:male,female',
            'dob' => 'nullable|date',
            'age' => 'nullable|integer|min:0|max:150',
            'marital_status' => 'nullable|in:divorced,separated,widowed,never_married',
            'number_of_children' => 'nullable|integer|min:0',
            'children_living_place' => 'nullable|in:living_with_me,not_living_with_me',

            // Education & Career (FIXED)
            'education' => 'nullable|string|max:255',
            'occupation' => 'nullable|string|max:255',
            'study_details' => 'nullable|string|max:500',
            'career_profile' => 'nullable|string|max:500',
            'earnings' => 'nullable|in:year,month',
            'income' => 'nullable|string|max:255',
            'income_amount' => 'nullable|numeric|min:0',


            // Physical Attributes
            'height' => 'nullable|numeric|min:30|max:300',
            'weight' => 'nullable|numeric|min:1|max:500',
            'eye_color' => 'nullable|string|max:50',
            'hair_color' => 'nullable|string|max:50',
            'complexion' => 'nullable|string|max:50',
            'blood_group' => 'nullable|string|max:10',
            'body_type' => 'nullable|string|max:50',
            'body_art' => 'nullable|string|max:255',
            'any_disability' => 'nullable|string|max:255',
            'physical_status' => 'nullable|string|max:255',


            // Place Details
            'country' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:500',
            'postal_code' => 'nullable|string|max:20',
            'mobile_number' => 'nullable|string|max:15',
            'mobile' => 'nullable|string|max:15',
            'alternate_number' => 'nullable|string|max:15',
            'landline' => 'nullable|string|max:20',

            // Family Details
            'surname' => 'nullable|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'father_vangusam' => 'nullable|string|max:255',
            'mother_occupation' => 'nullable|string|max:255',
            'family_type' => 'nullable|in:Joint,Nuclear',
            'brothers_count' => 'nullable|integer|min:0',
            'brothers_married' => 'nullable|integer|min:0',
            'sisters_count' => 'nullable|integer|min:0',
            'sisters_married' => 'nullable|integer|min:0',
            'mother_vangusam' => 'nullable|string|max:255',
            'family_status' => 'nullable|string|max:100',
            'property_description' => 'nullable|string|max:500',

            // Partner Preferences
            'preferred_age_max' => 'nullable|integer|min:18|max:100',
            'preferred_height_min' => 'nullable|numeric|min:30|max:300',
            'marital_status_preference' => 'nullable|in:Single,Divorced,Widowed',
            'caste' => 'nullable|string|max:100',
            'education_preference' => 'nullable|string|max:255',
            'dosham' => 'nullable|in:yes,no',

            // Astrology Details
            'birth_day' => 'nullable|date',
            'day_of_birth' => 'nullable|string|max:255',
            'birth_time' => 'nullable|string',
            'birth_city' => 'nullable|string|max:255',
            'paksha' => 'nullable|string|max:255',
            'star' => 'nullable|string|max:255',
            'rasi' => 'nullable|string|max:255',
            'nakshatra' => 'nullable|string|max:255',
            'charan' => 'nullable|string|max:255',
            'padam' => 'nullable|string|max:255',
            'ganam' => 'nullable|string|max:255',
            'nadi' => 'nullable|string|max:255',
            'type_of_dosham' => 'nullable|string|max:255',
            'other_dosham' => 'nullable|string|max:255',
            'lakknam' => 'nullable|string|max:255',
            'horoscope_matching' => 'nullable|string|max:255',
            'tithi' => 'nullable|string|max:255',
            'directional_balance' => 'nullable|string|max:255',
            'birth_place' => 'nullable|string|max:255', 
            'birth_country' => 'nullable|string|max:255',
            'birth_state' => 'nullable|string|max:255',
            'year' => 'nullable|integer',
            'month' => 'nullable|integer',
            'day' => 'nullable|integer',
            'date_of_birth' => 'nullable|date',
            'member_no' => 'nullable|string|max:30',
        ];


        // Validation rules for updating a profile
        $this->updateRules = [
            'introduction' => 'nullable|string',
            'name' => 'sometimes|string|max:255',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:15',


            'gender' => 'sometimes|in:male,female',
            'dob' => 'nullable|date',
            'age' => 'nullable|integer|min:0',
            'marital_status' => 'sometimes|in:divorced,separated,widowed,never_married',
            'number_of_children' => 'nullable|integer|min:0',
            'children_living_place' => 'nullable|in:living_with_me,not_living_with_me',
            'profile_created_for' => 'nullable|string|max:255',
            'registration_mode' => 'nullable|in:offline,online',
            'membership_type' => 'sometimes|in:default,essential,classic,prime,green,blue,yellow',
            'membership_expiry' => 'nullable|date',

            // Horoscope details
            'star' => 'nullable|string|max:255',
            'rasi' => 'nullable|string|max:255',
            'nakshatra' => 'nullable|string|max:255',
            'charan' => 'nullable|string|max:255',
            'padam' => 'nullable|string|max:255',
            'ganam' => 'nullable|string|max:255',
            'nadi' => 'nullable|string|max:255',
            'dosham' => 'nullable|string|max:255',
            'paksha' => 'nullable|string|max:255',
            'tithi' => 'nullable|string|max:255',
            'directional_balance' => 'nullable|string|max:255',
            'day_of_birth' => 'nullable|string|max:255',
            'birth_time' => 'nullable|string',
            'birth_place' => 'nullable|string|max:255',
            'birth_country' => 'nullable|string|max:255',
            'birth_state' => 'nullable|string|max:255',
            'birth_city' => 'nullable|string|max:255',
            'lakknam' => 'nullable|string|max:255',
            'horoscope_matching' => 'nullable|string|max:255',
            'type_of_dosham' => 'nullable|string|max:255',
            'other_dosham' => 'nullable|string|max:255',
            'year' => 'nullable|integer',
            'month' => 'nullable|integer',
            'day' => 'nullable|integer',

            // contact details

            'native_place' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'postal_code' => 'nullable|string|max:20',
            'mobile' => 'nullable|string|max:20',
            'alternate_number' => 'nullable|string|max:20',
            'landline' => 'nullable|string|max:20',
            'current_city' => 'nullable|string|max:255',

            // Cultural info
            'mother_tongue' => 'nullable|string|max:255',
            'religion' => 'nullable|string|max:255',
            'caste' => 'nullable|string|max:255',
            'subcaste' => 'nullable|string|max:255',
            'gothram' => 'nullable|string|max:255',

            // Physical details
            'height' => 'nullable|integer|min:0',
            'weight' => 'nullable|integer|min:0',
            'complexion' => 'nullable|string|max:255',
            'body_art' => 'nullable|string|max:255',

            'body_type' => 'nullable|string|max:255',
            'blood_group' => 'nullable|string|max:10',
            'physical_status' => 'nullable|string|max:255',
            'eye_color' => 'nullable|string|max:50',
            'hair_color' => 'nullable|string|max:50',

            // Education & career
            'education' => 'nullable|string|max:255',
            'occupation' => 'nullable|string|max:255',
            'income' => 'nullable|string|max:255',
            'work_location' => 'nullable|string|max:255',
            'study_details' => 'nullable|string',
            'career_profile' => 'nullable|string',
            'earnings' => 'nullable|in:year,month',
            'income_amount' => 'nullable|numeric|min:0',

            // Profile details
            'about_me' => 'nullable|string',
            'profile_photo' => 'nullable|image',
            'horoscope_file' => 'nullable|file',
            'date_of_birth' => 'nullable|date',
        ];
    }


    // public function getCurrentUserProfile(Request $request)
    // {
    //     try {
    //         $user = $request->user();

    //         Log::info('getCurrentUserProfile START', [
    //             'user_id' => $user?->id,
    //             'user_email' => $user?->email,
    //         ]);

    //         if (!$user) {
    //             Log::warning('getCurrentUserProfile: User not authenticated');
    //             return ApiResponse::error('Unauthenticated', null, 401);
    //         }

    //         $profile = $user->profile;

    //         Log::info('User profile fetched', [
    //             'user_id' => $user->id,
    //             'profile_id' => $profile?->id,
    //             'profile_exists' => $profile ? true : false,
    //         ]);

    //         if (!$profile) {
    //             Log::warning('getCurrentUserProfile: Profile not found', [
    //                 'user_id' => $user->id,
    //             ]);
    //             return ApiResponse::error('Profile not found', null, 404);
    //         }

    //         // ✅ ONLY ACTIVE MEMBER
    //         $member = $profile->activeMember;

    //         Log::info('Active member fetched', [
    //             'user_id' => $user->id,
    //             'profile_id' => $profile->id,
    //             'member_id' => $member?->id,
    //             'member_status' => $member?->status,
    //             'member_exists' => $member ? true : false,
    //         ]);

    //         if (!$member) {
    //             Log::warning('getCurrentUserProfile: No active membership found', [
    //                 'user_id' => $user->id,
    //                 'profile_id' => $profile->id,
    //             ]);
    //             // Optional: allow free users
    //             // or return limited profile
    //             return ApiResponse::error('No active membership found', null, 403);
    //         }

    //         Log::info('getCurrentUserProfile: Fetching full profile', [
    //             'profile_id' => $profile->id,
    //         ]);

    //         return $this->fetchFullProfile($profile->id);
    //     } catch (\Throwable $e) {
    //         Log::error('getCurrentUserProfile FAILED', [
    //             'error' => $e->getMessage(),
    //             'file' => $e->getFile(),
    //             'line' => $e->getLine(),
    //             'trace' => $e->getTraceAsString(),
    //         ]);

    //         return ApiResponse::error(
    //             'Failed to fetch current profile',
    //             $e->getMessage(),
    //             500
    //         );
    //     }
    // }

    public function getCurrentUserProfile(Request $request)
    {
        try {
            $user = $request->user();

            if (!$user) {
                return ApiResponse::error('Unauthenticated', null, 401);
            }

            $profile = $user->profile;

            if (!$profile) {
                return ApiResponse::error('Profile not found', null, 404);
            }

            // 🔥 NO MEMBERSHIP CHECK
            return $this->fetchFullProfile($profile->id);
        } catch (\Throwable $e) {

            Log::error('getCurrentUserProfile FAILED', [
                'error' => $e->getMessage(),
            ]);

            return ApiResponse::error(
                'Failed to fetch current profile',
                $e->getMessage(),
                500
            );
        }
    }

    //     public function index(Request $request)
    //     {
    //         try {
    //             $this->authorize('viewAny', Member::class);

    //             $currentUser = $request->user();

    //             $perPage = (int) $request->get('per_page', 20);
    //             $page = (int) $request->get('page', 1);

    //             // 🔎 SEARCH
    //             $search = trim(
    //                 $request->get('search')
    //                 ?? $request->get('name')
    //                 ?? ''
    //             );

    //             $userRole = $currentUser->role?->name ?? 'user';

    //             if (
    //                 !in_array($userRole, ['admin', 'super admin']) &&
    //                 $currentUser->profile?->registration_mode !== 'online'
    //             ) {
    //                 return ApiResponse::success('No profiles available', [
    //                     'current_page' => 1,
    //                     'per_page' => $perPage,
    //                     'total' => 0,
    //                     'last_page' => 1,
    //                     'data' => [],
    //                 ]);
    //             }

    //             $query = Member::query();

    //             // ❌ remove expired members
    //             $query->where('status', '!=', 'expired')->where('is_matched', false);

    //             /* ======================================================
    //              🔥 MAIN FILTER LOGIC
    //             ====================================================== */

    //             $query->where(function ($main) {

    //                 // 🟡 CASE 1 → ONLINE TEMPORARY INACTIVE
    //                 $main->where(function ($q) {
    //                     $q->whereHas('profile', function ($p) {
    //                         $p->where('registration_mode', 'online');
    //                     })
    //                         ->where('member_no', 'Temporary')
    //                         ->whereHas('membership', function ($m) {
    //                             $m->where('slug', 'default');
    //                         })
    //                         ->where('status', 'inactive');
    //                 })

    //                     // 🟢 CASE 2 → ONLINE ACTIVE MEMBERS
    //                     ->orWhere(function ($q) {
    //                         $q->whereHas('profile', function ($p) {
    //                             $p->where('registration_mode', 'online');
    //                         })
    //                             ->whereNotNull('prefix_id')
    //                             ->where('status', 'active');
    //                     })

    //                     // ⚪ CASE 3 → OTHER MEMBERS
    //                     ->orWhere(function ($q) {
    //                         $q->whereDoesntHave('profile', function ($p) {
    //                             $p->where('registration_mode', 'online');
    //                         });
    //                     });
    //             });

    //             /* ======================================================
    //              🔥 FINAL SORTING LOGIC
    //              Male/Female → highest number first
    //              Temporary → latest created first
    //             ====================================================== */

    //             $query->orderByRaw("
    //     CASE 
    //         WHEN member_no = 'Temporary' THEN 0
    //         ELSE 1
    //     END
    // ")
    //                 ->orderByRaw("
    //     CASE 
    //         WHEN member_no = 'Temporary'
    //         THEN created_at
    //     END DESC
    // ")
    //                 ->orderByRaw("
    //     CASE 
    //         WHEN member_no != 'Temporary'
    //         THEN CAST(REGEXP_REPLACE(member_no, '[^0-9]', '') AS UNSIGNED)
    //     END DESC
    // ")
    //                 ->orderByDesc('created_at');


    //             /* ======================================================
    //              🔎 SEARCH FILTER
    //             ====================================================== */

    //             if ($search !== '') {
    //                 $query->where(function ($q) use ($search) {
    //                     $q->where('member_no', $search)
    //                         ->orWhereHas('profile.user', function ($u) use ($search) {
    //                             $u->where('name', $search)
    //                                 ->orWhere('phone', $search);
    //                         })
    //                         ->orWhereHas('membership', function ($m) use ($search) {
    //                             $m->where('name', $search);
    //                         })
    //                         ->orWhere('status', $search)
    //                         ->orWhereHas('profile', function ($p) use ($search) {
    //                             $p->where('gender', $search);
    //                         })
    //                         ->orWhereHas('profile', function ($p) use ($search) {
    //                             $p->where('marital_status', $search);
    //                         });
    //                 });
    //             }

    //             /* ======================================================
    //              🔥 PAGINATION + RELATIONS
    //             ====================================================== */

    //             $paginated = $query->with([
    //                 'membership',
    //                 'profile' => function ($q) {
    //                     $q->with(['user', 'familyDetail'])
    //                         ->withCount([
    //                             'followers',
    //                             'following',
    //                             'interestsSent',
    //                             'interestsReceived',
    //                             'blockedProfiles',
    //                             'shortlistedProfiles',
    //                         ]);
    //                 }
    //             ])->paginate($perPage, ['*'], 'page', $page);

    //             /* ======================================================
    //              🔥 RESPONSE FORMAT
    //             ====================================================== */

    //             $data = collect($paginated->items())->map(function ($p) {
    //                 return [
    //                     'id' => $p->id,
    //                     'profile_id' => $p->profile->id ?? null,
    //                     'name' => $p->profile->user->name ?? null,
    //                     'profile_gender' => $p->profile->gender ?? null,
    //                     'membership_slug' => $p->membership->name ?? null,
    //                     'profile_marital_status' => $p->profile->marital_status ?? null,
    //                     'profiles_used' => $p->profiles_view_remaining ?? 0,
    //                     'is_reported' => $p->is_reported ?? false,
    //                     'member_no' => $p->member_no,
    //                     'member_created_date' => optional($p->created_at)->format('d-m-Y H:i:s'),
    //                     'soveran_details' => $p->profile->familyDetail->soveran_details ?? null,
    //                     'profile_photo' => $p->profile?->profile_photo
    //                         ? $p->profile->profile_photo
    //                         : (strtolower($p->profile?->gender) === 'female'
    //                             ? 'storage/default_image/default_female.jpg'
    //                             : 'storage/default_image/default_male.jpg'),
    //                     'phone' => $p->profile->user->phone ?? null,

    //                     'followers_count' => $p->profile->followers_count ?? 0,
    //                     'following_count' => $p->profile->following_count ?? 0,
    //                     'interest_sent_count' => $p->profile->interests_sent_count ?? 0,
    //                     'interest_received_count' => $p->profile->interests_received_count ?? 0,
    //                     'blocked_count' => $p->profile->blocked_profiles_count ?? 0,
    //                     'shortlist_count' => $p->profile->shortlisted_profiles_count ?? 0,
    //                     'is_renewed' => $p->isRenewed ?? 0,

    //                     'created_at' => optional($p->created_at)->format('d-m-Y'),
    //                     'status' => $p->status,
    //                 ];
    //             });

    //             return ApiResponse::success(
    //                 trans('messages.fetched_successfully'),
    //                 [
    //                     'current_page' => $paginated->currentPage(),
    //                     'per_page' => $paginated->perPage(),
    //                     'total' => $paginated->total(),
    //                     'last_page' => $paginated->lastPage(),
    //                     'data' => $data,
    //                 ]
    //             );
    //         } catch (\Throwable $e) {
    //             return ApiResponse::error('Failed to fetch', $e->getMessage(), 500);
    //         }
    //     }

    public function index(Request $request)
    {
        try {
            $this->authorize('viewAny', Member::class);

            $currentUser = $request->user();

            $perPage = (int) $request->get('per_page', 20);
            $page = (int) $request->get('page', 1);

            // 🔎 SEARCH
            $search = trim((string) $request->get('search', ''));

            // Explicit table filters (combined with AND logic)
            $memberNoFilter = trim((string) $request->get('member_no', ''));
            $nameFilter = trim((string) $request->get('name', ''));
            $phoneFilter = trim((string) $request->get('phone', ''));
            $genderFilter = strtolower(trim((string) $request->get('profile_gender', '')));
            $membershipFilter = strtolower(trim((string) $request->get('membership_slug', '')));
            $statusFilter = strtolower(trim((string) $request->get('status', '')));

            /* ======================================================
             🔐 ROLE CHECK
            ====================================================== */
            $userRole = $currentUser->role?->name ?? 'user';

            if (!in_array($userRole, ['admin', 'super admin'])) {
                return ApiResponse::error('Unauthorized access', 403);
            }

            /* ======================================================
             🧩 BASE QUERY → ALL MEMBERS
            ====================================================== */
            $query = Member::query();
            
            // 🔥 APPLY DUPLICATE FILTER
            $this->applyDuplicateFilter($query);

            // optional filters (remove panna vendumna remove pannalaam)
            $query->where('is_matched', false);

            if ($request->boolean('exclude_temporary')) {
                $query->where('member_no', '!=', 'Temporary');
            }

            if ($memberNoFilter !== '') {
                $query->where('member_no', 'like', "%{$memberNoFilter}%");
            }

            if ($nameFilter !== '') {
                $query->whereHas('profile.user', function ($u) use ($nameFilter) {
                    $u->where('name', 'like', "%{$nameFilter}%");
                });
            }

            if ($phoneFilter !== '') {
                $query->whereHas('profile.user', function ($u) use ($phoneFilter) {
                    $u->where('phone', 'like', "%{$phoneFilter}%");
                });
            }

            if ($genderFilter !== '') {
                $query->whereHas('profile', function ($p) use ($genderFilter) {
                    $p->whereRaw('LOWER(gender) = ?', [$genderFilter]);
                });
            }

            if ($membershipFilter !== '') {
                $query->whereHas('membership', function ($m) use ($membershipFilter) {
                    $m->whereRaw('LOWER(slug) = ?', [$membershipFilter])
                        ->orWhereRaw('LOWER(name) = ?', [$membershipFilter]);
                });
            }

            if ($statusFilter !== '') {
                $query->whereRaw('LOWER(status) = ?', [$statusFilter]);
            }

            /* ======================================================
             🔥 SORTING LOGIC (UNCHANGED)
             Temporary → latest first
             Others → highest member number first
            ====================================================== */
            $query->orderByRaw("
            CASE 
                WHEN member_no = 'Temporary' THEN 0
                ELSE 1
            END
        ")
                ->orderByRaw("
            CASE 
                WHEN member_no = 'Temporary'
                THEN created_at
            END DESC
        ")
                ->orderByRaw("
            CASE 
                WHEN member_no != 'Temporary'
                THEN CAST(REGEXP_REPLACE(member_no, '[^0-9]', '') AS UNSIGNED)
            END DESC
        ")
                ->orderByDesc('created_at');

            /* ======================================================
             🔎 SEARCH FILTER
            ====================================================== */
            if ($search !== '') {
                $query->where(function ($q) use ($search) {
                    $q->where('member_no', $search)
                        ->orWhereHas('profile.user', function ($u) use ($search) {
                            $u->where('name', $search)
                                ->orWhere('phone', $search);
                        })
                        ->orWhereHas('membership', function ($m) use ($search) {
                            $m->where('name', $search);
                        })
                        ->orWhere('status', $search)
                        ->orWhereHas('profile', function ($p) use ($search) {
                            $p->where('gender', $search);
                        })
                        ->orWhereHas('profile', function ($p) use ($search) {
                            $p->where('marital_status', $search);
                        });
                });
            }

            /* ======================================================
             🔥 PAGINATION + RELATIONS
            ====================================================== */
            $paginated = $query->with([
                'membership',
                'profile' => function ($q) {
                    $q->with(['user', 'familyDetail'])
                        ->withCount([
                            'followers',
                            'following',
                            'interestsSent',
                            'interestsReceived',
                            'blockedProfiles',
                            'shortlistedProfiles',
                        ]);
                }
            ])->paginate($perPage, ['*'], 'page', $page);

            /* ======================================================
             🔥 RESPONSE FORMAT
            ====================================================== */
            $data = collect($paginated->items())->map(function ($p) {
                return [
                    'id' => $p->id,
                    'profile_id' => $p->profile->id ?? null,
                    'name' => $p->profile->user->name ?? null,
                    'profile_gender' => $p->profile->gender ?? null,
                    'membership_slug' => $p->membership->name ?? null,
                    'profile_marital_status' => $p->profile->marital_status ?? null,
                    'profiles_used' => $p->profiles_view_remaining ?? 0,
                    'is_reported' => $p->is_reported ?? false,
                    'member_no' => $p->member_no,
                    'member_created_date' => optional($p->created_at)->format('d-m-Y H:i:s'),
                    'soveran_details' => $p->profile->familyDetail->soveran_details ?? null,
                    'profile_photo' => $p->profile?->profile_photo
                        ? $p->profile->profile_photo
                        : (strtolower($p->profile?->gender) === 'female'
                            ? 'storage/default_image/default_female.jpg'
                            : 'storage/default_image/default_male.jpg'),
                    'phone' => $p->profile->user->phone ?? null,

                    'followers_count' => $p->profile->followers_count ?? 0,
                    'following_count' => $p->profile->following_count ?? 0,
                    'interest_sent_count' => $p->profile->interests_sent_count ?? 0,
                    'interest_received_count' => $p->profile->interests_received_count ?? 0,
                    'blocked_count' => $p->profile->blocked_profiles_count ?? 0,
                    'shortlist_count' => $p->profile->shortlisted_profiles_count ?? 0,
                    'is_renewed' => $p->isRenewed ?? 0,

                    'created_at' => optional($p->created_at)->format('d-m-Y'),
                    'status' => $p->status,
                ];
            });

            return ApiResponse::success(
                trans('messages.fetched_successfully'),
                [
                    'current_page' => $paginated->currentPage(),
                    'per_page' => $paginated->perPage(),
                    'total' => $paginated->total(),
                    'last_page' => $paginated->lastPage(),
                    'data' => $data,
                ]
            );
        } catch (\Throwable $e) {
            return ApiResponse::error('Failed to fetch', $e->getMessage(), 500);
        }
    }


    public function adminGetById($id, Request $request)
    {
        try {

            $this->authorize('view', Member::class);

            // 🔹 Load member with relations
            $member = Member::with($request->get('with', [
                'profile',
                'profile.user',
                'profile.familyDetail',
                'profile.partnerPreference',
                'profile.photos',
                'profile.horoscopeBoxes',
                'membership'
            ]))->findOrFail($id);

            $profile = $member->profile;

            if ($profile) {

                /* ===========================
                 | FOLLOW COUNTS
                 =========================== */

                $followersCount = ProfileAction::where('to_profile_id', $profile->id)
                    ->where('action_type', 'follow')
                    ->count();

                $followingCount = ProfileAction::where('from_profile_id', $profile->id)
                    ->where('action_type', 'follow')
                    ->count();

                /* ===========================
                 | PROFILE VIEW USAGE (SAFE)
                 =========================== */

                $profilesViewAllowed = (int) ($member->profiles_view_allowed ?? 0);
                $profilesViewRemaining = (int) ($member->profiles_view_remaining ?? 0);

                $profilesViewUsed = max(
                    0,
                    $profilesViewAllowed - $profilesViewRemaining
                );

                /* ===========================
                 | ATTACH NON-DB ATTRIBUTES
                 =========================== */

                $profile->followers_count = $followersCount;
                $profile->following_count = $followingCount;

                $member->profiles_view_used = $profilesViewUsed;
            }

            Log::info('ACTION: Admin viewing member record', [
                'admin_id' => Auth::id(),
                'member_id' => $id,
            ]);

            return ApiResponse::success('Record found', $member);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {

            return ApiResponse::error('Unauthorized', $e->getMessage(), 403);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            return ApiResponse::error('Record not found', null, 404);
        } catch (\Throwable $e) {

            Log::error('adminGetById FAILED', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return ApiResponse::error('Failed to retrieve record', $e->getMessage(), 500);
        }
    }


    public function mobilePdfDownload(Request $request, $id)
    {
        try {
            $lang = $request->query('lang', 'ta');
            
            // Fetch member with all necessary relations for the print template
            $member = Member::with([
                'profile',
                'profile.user',
                'profile.familyDetail',
                'profile.partnerPreference',
                'profile.photos',
                'profile.horoscopeBoxes',
                'membership'
            ])->findOrFail($id);

            $profile = $member->profile;

            if (!$profile) {
                return ApiResponse::error('Profile not found', null, 404);
            }

            // Process Horoscope boxes
            $zodiacBoxes = array_fill(0, 12, array_fill(0, 6, ''));
            $featureBoxes = array_fill(0, 12, array_fill(0, 6, ''));

            foreach ($profile->horoscopeBoxes as $row) {
                if ($row->type === 'ZODIAC') {
                    $zodiacBoxes[$row->box_number - 1][$row->item_number - 1] = $row->value ?? '';
                } elseif ($row->type === 'FEATURE') {
                    $featureBoxes[$row->box_number - 1][$row->item_number - 1] = $row->value ?? '';
                }
            }

            // Load translations from Angular assets
            $jsonFile = $lang === 'en' ? 'en.json' : 'ta.json';
            $jsonPath = base_path("../../thirumanam-frontend/projects/matrimony/src/assets/i18n/{$jsonFile}");
            $translations = [];
            if (file_exists($jsonPath)) {
                $translations = json_decode(file_get_contents($jsonPath), true);
            }

            $toKey = function ($value) {
                if ($value === null || $value === '')
                    return '-';
                $normalized = trim($value);
                if ($normalized === '-' || strtolower($normalized) === 'null')
                    return '-';

                return strtoupper(preg_replace('/[^a-zA-Z0-9_]/', '_', $normalized));
            };

            $checkLaknam = function ($values) {
                if (!is_array($values))
                    return false;
                $targetWords = ['laknam', 'lakknam', 'lagnam', 'ascendant', 'l'];
                foreach ($values as $v) {
                    if (!$v)
                        continue;
                    $str = strtolower(trim($v));
                    if ($str === 'l')
                        return true;
                    foreach ($targetWords as $word) {
                        if ($word !== 'l' && str_contains($str, $word))
                            return true;
                    }
                }
                return false;
            };

            $translate = function ($key, $prefix = 'FORM.') use ($translations, $toKey) {
                if (!$key || $key === '-')
                    return '-';

                $searchKey = $toKey($key);

                // Try with prefix first
                $fullKey = $prefix . $searchKey;
                $keys = explode('.', $fullKey);
                $current = $translations;
                foreach ($keys as $k) {
                    if (isset($current[$k])) {
                        $current = $current[$k];
                    } else {
                        $current = null;
                        break;
                    }
                }

                if ($current && is_string($current))
                    return $current;

                // Try without prefix (top level)
                if (isset($translations[$searchKey]) && is_string($translations[$searchKey])) {
                    return $translations[$searchKey];
                }

                return $key;
            };

            // Prepare data for the view
            $data = [
                'member' => $member,
                'profile' => $profile,
                'user' => $profile->user,
                'family' => $profile->familyDetail,
                'partner' => $profile->partnerPreference,
                'membership' => $member->membership,
                'zodiacBoxes' => $zodiacBoxes,
                'featureBoxes' => $featureBoxes,
                'imageUrl' => config('app.url') . '/images',
                'logoPath' => public_path('images/logo.png'),
                'acsLogoPath' => storage_path('app/public/logo/acs_logo.png'),
                'adPath' => storage_path('app/public/logo/ad.png'),
                'defaultMale' => public_path('images/male-default-img.jpg'),
                'defaultFemale' => public_path('images/female_default_img.jpg'),
                'translate' => $translate,
                'toKey' => $toKey,
                'checkLaknam' => $checkLaknam,
                'lang' => $lang
            ];

            // Generate PDF with options for better font support
            $pdf = Pdf::setOption([
                'isRemoteEnabled' => true,
                'isFontSubsettingEnabled' => true,
                'isHtml5ParserEnabled' => true,
                'defaultFont' => 'tamilfont'
            ])->loadView('pdf.profile', $data);

            // Optional: Set paper size, margins etc.
            $pdf->setPaper('a4', 'portrait');

            return $pdf->stream('Profile-' . $member->member_no . '.pdf');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return ApiResponse::error('Member not found', null, 404);
        } catch (\Throwable $e) {
            Log::error('mobilePdfDownload FAILED', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            return ApiResponse::error('Failed to generate PDF', $e->getMessage(), 500);
        }
    }
    public function adminPrint(Request $request)
    {
        try {

            $ids = $request->ids; // [1] or [1,2,3]

            $members = Member::with([
                'profile',
                'profile.user',
                'profile.familyDetail',
                'profile.partnerPreference',
                'profile.photos',
                'profile.horoscopeBoxes',
                'membership'
            ])->whereIn('id', $ids)->get();

            return ApiResponse::success('Profiles fetched', $members);
        } catch (\Throwable $e) {
            return ApiResponse::error('Failed', $e->getMessage(), 500);
        }
    }


    // public function getAllFilterMemberBySavaran(Request $request)
    // {
    //     try {
    //         Log::info('--- getAllFilterMemberBySavaran START ---');

    //         // 🔹 Current user
    //         $currentUser = $request->user();

    //         $userRole = $currentUser->role?->name ?? 'user';
    //         $registrationMode = $currentUser->profile?->registration_mode;

    //         // 🔒 Registration mode check
    //         if (
    //             !in_array($userRole, ['admin', 'super admin']) &&
    //             $registrationMode !== 'online'
    //         ) {
    //             return ApiResponse::success('No profiles available', []);
    //         }

    //         // 🔹 Current user membership
    //         $member = $currentUser->profile?->member;
    //         $membership = $member?->membership;

    //         $userPlanSlug = strtolower($membership?->slug ?? 'default');   // default / essential / classic / prime
    //         $userSavaranLimit = (int) ($membership?->savaran_plan ?? 0);    // 0 / 25 / 50 / 999+

    //         Log::info('Current user plan', [
    //             'slug' => $userPlanSlug,
    //             'savaran_limit' => $userSavaranLimit
    //         ]);

    //         // 🔹 Gender logic
    //         $userGender = $currentUser->profile?->gender;
    //         $oppositeGender = $userGender === 'male'
    //             ? 'female'
    //             : ($userGender === 'female' ? 'male' : null);

    //         // 🔹 Base query
    //         $query = Member::query();

    //         // 🔒 Status filter (non-admin)
    //         if (!in_array($userRole, ['admin', 'super admin'])) {
    //             $query->where('status', 'active');
    //         }

    //         // 🔒 Gender filter (non-admin)
    //         if ($oppositeGender && !in_array($userRole, ['admin', 'super admin'])) {
    //             $query->whereHas('profile', function ($q) use ($oppositeGender) {
    //                 $q->where('gender', $oppositeGender);
    //             });
    //         }

    //         /**
    //          * 🔥 FINAL SAVARAN + MEMBERSHIP LOGIC
    //          */

    //         // ❌ Default profiles should NOT appear for paid users
    //         if ($userPlanSlug !== 'default') {
    //             $query->whereHas('membership', function ($q) {
    //                 $q->where('slug', '!=', 'default');
    //             });

    //             Log::info('Default profiles excluded');
    //         }

    //         if ($userPlanSlug === 'essential') {

    //             // ONLY Essential (1–25)
    //             $query->whereHas('profile.familyDetail', function ($q) {
    //                 $q->whereBetween('soveran_details', [1, 25]);
    //             });

    //             $query->whereHas('membership', function ($q) {
    //                 $q->where('savaran_plan', '<=', 25);
    //             });

    //             Log::info('Essential filter applied');
    //         } elseif ($userPlanSlug === 'classic') {

    //             // Essential + Classic (1–50)
    //             $query->whereHas('profile.familyDetail', function ($q) {
    //                 $q->whereBetween('soveran_details', [1, 50]);
    //             });

    //             $query->whereHas('membership', function ($q) {
    //                 $q->where('savaran_plan', '<=', 50);
    //             });

    //             Log::info('Classic filter applied');
    //         } elseif ($userPlanSlug === 'prime') {

    //             // Essential + Classic + Prime (>=1)
    //             $query->whereHas('profile.familyDetail', function ($q) {
    //                 $q->where('soveran_details', '>=', 1);
    //             });

    //             $query->whereHas('membership', function ($q) {
    //                 $q->where('savaran_plan', '>', 0);
    //             });

    //             Log::info('Prime filter applied');
    //         }
    //         // ✅ Default user → NO FILTER AT ALL

    //         Log::info('Executing query', [
    //             'sql' => $query->toSql(),
    //             'bindings' => $query->getBindings(),
    //         ]);

    //         // 🔹 Fetch profiles
    //         $profiles = $query->with([
    //             'membership',
    //             'profile',
    //             'profile.user',
    //             'profile.familyDetail',
    //             'profile.followers',
    //             'profile.following',
    //         ])->get();

    //         Log::info('Profiles fetched', ['count' => $profiles->count()]);

    //         // 🔹 Response mapping
    //         $data = $profiles->map(fn($p) => [
    //             'id' => $p->id,
    //             'member_no' => $p->member_no,
    //             'profile_id' => $p->profile?->id,
    //             'name' => $p->profile?->user?->name,
    //             'profile_gender' => $p->profile?->gender,
    //             'age' => $p->profile?->age,
    //             'profile_marital_status' => $p->profile?->marital_status,
    //             'profile_photo' => $p->profile?->profile_photo
    //                 ? $p->profile->profile_photo
    //                 : (strtolower($p->profile?->gender) === 'female'
    //                     ? 'storage/default_image/default_female.jpg'
    //                     : 'storage/default_image/default_male.jpg'),
    //             'membership_slug' => $p->membership?->name,
    //             'soveran_details' => $p->profile?->familyDetail?->soveran_details,
    //             'followers_count' => $p->profile?->followers?->count() ?? 0,
    //             'following_count' => $p->profile?->following?->count() ?? 0,
    //             'created_at' => $p->created_at?->format('d-m-Y'),
    //             'status' => $p->status,
    //         ]);

    //         Log::info('--- getAllFilterMemberBySavaran END SUCCESS ---');

    //         return ApiResponse::success(
    //             'Fetched successfully',
    //             [
    //                 'current_user_plan' => ucfirst($userPlanSlug),
    //                 'profiles' => $data
    //             ]
    //         );
    //     } catch (\Throwable $e) {

    //         Log::error('getAllFilterMemberBySavaran FAILED', [
    //             'message' => $e->getMessage(),
    //             'file' => $e->getFile(),
    //             'line' => $e->getLine(),
    //         ]);

    //         return ApiResponse::error(
    //             'Failed to fetch members',
    //             $e->getMessage(),
    //             500
    //         );
    //     }
    // }


    // public function getAllFilterMemberBySavaran(Request $request)
    // {
    //     try {
    //         Log::info('--- getAllFilterMemberBySavaran START ---');

    //         $currentUser = $request->user();
    //         $userRole = $currentUser->role?->name ?? 'user';

    //         // 🔹 Current user membership
    //         $member = $currentUser->profile?->member;
    //         $membership = $member?->membership;

    //         $userSavaranLimit = (int) ($membership?->savaran_plan ?? 0);
    //         $membershipMode = $membership?->membership_mode; // online / offline
    //         $currentSlug = $membership?->slug;

    //         Log::info('Current user membership', [
    //             'savaran_limit' => $userSavaranLimit,
    //             'mode' => $membershipMode,
    //             'slug' => $currentSlug
    //         ]);

    //         // 🔹 Gender logic
    //         $userGender = $currentUser->profile?->gender;
    //         $oppositeGender = $userGender === 'male'
    //             ? 'female'
    //             : ($userGender === 'female' ? 'male' : null);

    //         $query = Member::query();

    //         /**
    //          * 🔒 SAFETY FILTERS (NON ADMIN USERS)
    //          */
    //         if (!in_array($userRole, ['admin', 'super admin'])) {

    //             $query->where('status', 'active');

    //             $query->where('is_deleted', 0)
    //                 ->where('is_closed', 'no')
    //                 ->where('blocked_by_admin', 0)
    //                 ->where('rejected_by_admin', 0)
    //                 ->where('is_deactivated', 0)
    //                 ->where('membership_expired', 0)
    //                 ->whereNull('deleted_at');

    //             // Gender filter
    //             if ($oppositeGender) {
    //                 $query->whereHas('profile', function ($q) use ($oppositeGender) {
    //                     $q->where('gender', $oppositeGender);
    //                 });
    //             }
    //         }

    //         /**
    //          * 🔥 MEMBERSHIP VISIBILITY LOGIC
    //          */

    //         if ($membershipMode === 'offline') {

    //             // 🏢 OFFLINE LOGIN → same membership plan only
    //             $query->whereHas('membership', function ($q) use ($currentSlug) {
    //                 $q->where('slug', $currentSlug);
    //             });

    //             Log::info('Offline membership filter applied', [
    //                 'slug' => $currentSlug
    //             ]);
    //         } else {

    //             // 🌐 ONLINE LOGIN → savaran hierarchy
    //             if ($userSavaranLimit <= 0) {

    //                 // default user
    //                 $query->whereHas('membership', function ($q) {
    //                     $q->where('savaran_plan', 0);
    //                 });

    //                 Log::info('Default members only');
    //             } else {

    //                 $limit = $userSavaranLimit;

    //                 // membership savaran filter
    //                 $query->whereHas('membership', function ($q) use ($limit) {
    //                     $q->where('savaran_plan', '>', 0)
    //                         ->where('savaran_plan', '<=', $limit);
    //                 });

    //                 // profile family savaran filter
    //                 $query->whereHas('profile.familyDetail', function ($q) use ($limit) {
    //                     $q->where('soveran_details', '>=', 1)
    //                         ->where('soveran_details', '<=', $limit);
    //                 });

    //                 Log::info('Online savaran hierarchy applied', [
    //                     'limit' => $limit
    //                 ]);
    //             }
    //         }

    //         Log::info('Executing query', [
    //             'sql' => $query->toSql(),
    //             'bindings' => $query->getBindings(),
    //         ]);

    //         // 🔹 Fetch members
    //         $profiles = $query->with([
    //             'membership',
    //             'profile',
    //             'profile.user',
    //             'profile.familyDetail',
    //             'profile.followers',
    //             'profile.following',
    //         ])->get();

    //         Log::info('Profiles fetched', ['count' => $profiles->count()]);

    //         // 🔹 Response mapping
    //         $data = $profiles->map(fn($p) => [
    //             'id' => $p->id,
    //             'member_no' => $p->member_no,
    //             'profile_id' => $p->profile?->id,
    //             'name' => $p->profile?->user?->name,
    //             'profile_gender' => $p->profile?->gender,
    //             'age' => $p->profile?->age,
    //             'profile_marital_status' => $p->profile?->marital_status,
    //             'profile_photo' => $p->profile?->profile_photo
    //                 ? $p->profile->profile_photo
    //                 : (strtolower($p->profile?->gender) === 'female'
    //                     ? 'storage/default_image/default_female.jpg'
    //                     : 'storage/default_image/default_male.jpg'),
    //             'membership_slug' => $p->membership?->slug,
    //             'membership_name' => $p->membership?->name,
    //             'membership_mode' => $p->membership?->membership_mode,
    //             'soveran_details' => $p->profile?->familyDetail?->soveran_details,
    //             'followers_count' => $p->profile?->followers?->count() ?? 0,
    //             'following_count' => $p->profile?->following?->count() ?? 0,
    //             'created_at' => $p->created_at?->format('d-m-Y'),
    //             'status' => $p->status,
    //         ]);

    //         Log::info('--- getAllFilterMemberBySavaran END SUCCESS ---');

    //         return ApiResponse::success(
    //             'Fetched successfully',
    //             [
    //                 'current_user_mode' => $membershipMode,
    //                 'current_user_savaran_limit' => $userSavaranLimit,
    //                 'profiles' => $data
    //             ]
    //         );
    //     } catch (\Throwable $e) {

    //         Log::error('getAllFilterMemberBySavaran FAILED', [
    //             'message' => $e->getMessage(),
    //             'file' => $e->getFile(),
    //             'line' => $e->getLine(),
    //         ]);

    //         return ApiResponse::error(
    //             'Failed to fetch members',
    //             $e->getMessage(),
    //             500
    //         );
    //     }
    // }

    public function getAllFilterMemberBySavaran(Request $request)
    {
        try {
            Log::info('--- getAllFilterMemberBySavaran START ---');

            $currentUser = $request->user();
            $userRole = $currentUser->role?->name ?? 'user';

            // 🔹 Current user membership
            $member = $currentUser->profile?->member;
            $membership = $member?->membership;

            $userSavaranLimit = (int) ($membership?->savaran_plan ?? 0);
            $membershipMode = $membership?->membership_mode; // online / offline
            $currentSlug = strtolower($membership?->slug ?? 'default');

            Log::info('Current user membership', [
                'savaran_limit' => $userSavaranLimit,
                'mode' => $membershipMode,
                'slug' => $currentSlug
            ]);

            // 🔹 Gender logic
            $userGender = $currentUser->profile?->gender;
            $oppositeGender = $userGender === 'male'
                ? 'female'
                : ($userGender === 'female' ? 'male' : null);

            $query = Member::query();

            /**
             * 🔒 SAFETY FILTERS (NEW CODE)
             */
            if (!in_array($userRole, ['admin', 'super admin'])) {

                $query->where('status', 'active');

                $query->where('is_deleted', 0)
                    ->where('is_closed', 'no')
                    ->where('blocked_by_admin', 0)
                    ->where('rejected_by_admin', 0)
                    ->where('is_deactivated', 0)
                    ->where('membership_expired', 0)
                    ->whereNull('deleted_at');

                // Gender filter
                if ($oppositeGender) {
                    $query->whereHas('profile', function ($q) use ($oppositeGender) {
                        $q->where('gender', $oppositeGender);
                    });
                }
            }

            /**
             * 🏢 OFFLINE LOGIC (NEW CODE)
             */
            if ($membershipMode === 'offline') {

                $query->whereHas('membership', function ($q) use ($currentSlug) {
                    $q->where('slug', $currentSlug);
                });

                Log::info('Offline membership filter applied');
            } else {

                /**
                 * 🔥 OLD MEMBERSHIP PLAN LOGIC IMPLEMENTED
                 */

                // ❌ Paid users should NOT see default members
                if ($currentSlug !== 'default') {
                    $query->whereHas('membership', function ($q) {
                        $q->where('slug', '!=', 'default');
                    });
                }

                if ($currentSlug === 'essential') {

                    $query->whereHas('profile.familyDetail', function ($q) {
                        $q->whereBetween('soveran_details', [1, 25]);
                    });

                    $query->whereHas('membership', function ($q) {
                        $q->where('savaran_plan', '<=', 25);
                    });

                    Log::info('Essential plan applied');
                } elseif ($currentSlug === 'classic') {

                    $query->whereHas('profile.familyDetail', function ($q) {
                        $q->whereBetween('soveran_details', [1, 50]);
                    });

                    $query->whereHas('membership', function ($q) {
                        $q->where('savaran_plan', '<=', 50);
                    });

                    Log::info('Classic plan applied');
                } elseif ($currentSlug === 'prime') {

                    $query->whereHas('profile.familyDetail', function ($q) {
                        $q->where('soveran_details', '>=', 1);
                    });

                    $query->whereHas('membership', function ($q) {
                        $q->where('savaran_plan', '>', 0);
                    });

                    Log::info('Prime plan applied');
                }
                // ✅ default → no filter (all members visible)
            }

            Log::info('Executing query', [
                'sql' => $query->toSql(),
                'bindings' => $query->getBindings(),
            ]);

            // 🔹 Fetch members
            $profiles = $query->with([
                'membership',
                'profile',
                'profile.user',
                'profile.familyDetail',
                'profile.followers',
                'profile.following',
            ])->get();

            Log::info('Profiles fetched', ['count' => $profiles->count()]);

            // 🔹 Response mapping
            $data = $profiles->map(fn($p) => [
                'id' => $p->id,
                'member_no' => $p->member_no,
                'profile_id' => $p->profile?->id,
                'name' => $p->profile?->user?->name,
                'profile_gender' => $p->profile?->gender,
                'age' => $p->profile?->age,
                'profile_marital_status' => $p->profile?->marital_status,
                'study_details' => $p->profile?->study_details,
                'occupation' => $p->profile?->occupation,
                'profile_photo' => $p->profile?->profile_photo
                    ? $p->profile->profile_photo
                    : (strtolower($p->profile?->gender) === 'female'
                        ? 'storage/default_image/default_female.jpg'
                        : 'storage/default_image/default_male.jpg'),
                'membership_slug' => $p->membership?->slug,
                'membership_name' => $p->membership?->name,
                'membership_mode' => $p->membership?->membership_mode,
                'star' => $p->profile?->star,
                'type_of_dosham' => $p->profile?->type_of_dosham,
                'soveran_details' => $p->profile?->familyDetail?->soveran_details,
                'father_vangusam' => $p->profile?->familyDetail?->father_vangusam,
                'profession' => $p->profile?->partnerPreference?->profession,
                'education' => $p->profile?->partnerPreference?->education,
                'followers_count' => $p->profile?->followers?->count() ?? 0,
                'following_count' => $p->profile?->following?->count() ?? 0,
                'created_at' => $p->created_at?->format('d-m-Y'),
                'status' => $p->status,
            ]);

            Log::info('--- getAllFilterMemberBySavaran END SUCCESS ---');

            return ApiResponse::success(
                'Fetched successfully',
                [
                    'current_user_mode' => $membershipMode,
                    'current_user_plan' => ucfirst($currentSlug),
                    'profiles' => $data
                ]
            );
        } catch (\Throwable $e) {

            Log::error('getAllFilterMemberBySavaran FAILED', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return ApiResponse::error(
                'Failed to fetch members',
                $e->getMessage(),
                500
            );
        }
    }

    public function show($id, Request $request)
    {
        try {

            /* =====================================================
         | AUTH & VIEWER DATA
         ===================================================== */
            $authUser = $request->user();
            $viewerProfile = $authUser?->profile;
            $viewerProfileId = $viewerProfile?->id;
            $viewerMember = $viewerProfile?->member;

            /* =====================================================
         | TARGET PROFILE
         ===================================================== */
            $targetProfile = Profile::with([
                'user',
                'familyDetail',
                'partnerPreference',
                'member',
            ])->withCount([
                        'followers',
                        'following',
                        'interestsSent',
                        'interestsReceived',
                        'blockedProfiles',
                        'shortlistedProfiles',
                    ])->findOrFail($id);

            /* =====================================================
         | 1️⃣ SELF PROFILE → FULL ACCESS
         ===================================================== */
            if ($viewerProfileId && $viewerProfileId === $targetProfile->id) {
                return $this->fetchFullProfile($id);
            }

            /* =====================================================
         | 2️⃣ MEMBERSHIP & QUOTA CHECK
         ===================================================== */
            $profilesAllowed = $viewerMember?->profiles_view_allowed ?? 0;
            $profilesUsed = $viewerMember?->profiles_view_used ?? 0;
            $membershipSlug = $viewerMember?->membership?->slug ?? 'default';

            $isRestricted = (
                $membershipSlug === 'default' ||
                $profilesUsed >= $profilesAllowed
            );

            /* =====================================================
         | 3️⃣ INTERACTIONS (FOLLOW / BLOCK / SHORTLIST / INTEREST)
         ===================================================== */
            $interactions = [
                'has_sent_interest' => false,
                'is_following' => false,
                'has_blocked' => false,
                'has_shortlisted' => false,
            ];

            if ($viewerProfileId) {

                // Follow / Block / Shortlist
                $actions = ProfileAction::where('from_profile_id', $viewerProfileId)
                    ->where('to_profile_id', $targetProfile->id)
                    ->pluck('action_type')
                    ->flip();

                // Interest (CORRECT COLUMN NAMES)
                $hasSentInterest = \App\Models\Interest::where(
                    'sender_profile_id',
                    $viewerProfileId
                )->where(
                        'receiver_profile_id',
                        $targetProfile->id
                    )->exists();

                $interactions = [
                    'has_sent_interest' => $hasSentInterest,
                    'is_following' => isset($actions['follow']),
                    'has_blocked' => isset($actions['block']),
                    'has_shortlisted' => isset($actions['shortlist']),
                ];
            }

            /* =====================================================
         | 4️⃣ RESTRICTED VIEW
         ===================================================== */
            if ($isRestricted) {

                $data = [
                    'id' => $targetProfile->id,
                    'restricted' => true,
                    'upgrade_required' => true,
                    'is_default' => $membershipSlug === 'default',
                    'quota_remaining' => max(0, $profilesAllowed - $profilesUsed),
                    'member_no' => $targetProfile->member?->member_no,
                    'interactions' => $interactions,

                    'basic' => [
                        'name' => $targetProfile->user?->name,
                        'gender' => $targetProfile->gender,
                        'age' => $targetProfile->age,
                        'dob' => $targetProfile->dob,
                        'marital_status' => $targetProfile->marital_status,
                        'physical_status' => $targetProfile->physical_status,
                        'profile_photo' => $targetProfile->profile_photo,
                    ],

                    'partner' => $targetProfile->partnerPreference ? [
                        'about_partner' => $targetProfile->partnerPreference->about_partner,
                        'preferred_age' =>
                            $targetProfile->partnerPreference->preferred_age_min .
                            ' - ' .
                            $targetProfile->partnerPreference->preferred_age_max,
                        'education' => $targetProfile->partnerPreference->education,
                        'caste' => $targetProfile->partnerPreference->caste,
                        'marital_status' => $targetProfile->partnerPreference->marital_status,
                        'dosham' => $targetProfile->partnerPreference->dosham,
                    ] : null,

                    'images' => [],
                ];

                return ApiResponse::success('Restricted Profile', $data);
            }

            /* =====================================================
         | 5️⃣ FULL ACCESS
         ===================================================== */
            return $this->fetchFullProfile($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            return ApiResponse::error('Profile not found', null, 404);
        } catch (\Throwable $e) {

            return ApiResponse::error('Failed to retrieve profile', $e->getMessage(), 500);
        }
    }

    public function getFilteredMemberDetails($id, Request $request)
    {
        try {

            /* =====================================================
             | AUTH & VIEWER
             ===================================================== */
            $authUser = $request->user();
            $viewerProfileId = $authUser?->profile?->id;
            $viewerMember = $authUser?->profile?->activeMember;

            Log::info('getFilteredMemberDetails: Viewer Quotas', [
                'viewer_profile_id' => $viewerProfileId,
                'member_id' => $viewerMember?->id,
                'interests_remaining' => $viewerMember?->sent_interest_remaining,
                'messages_remaining' => $viewerMember?->messages_sent_remaining,
            ]);

            /* =====================================================
             | TARGET PROFILE
             ===================================================== */
            $targetProfile = Profile::with([
                'user',
                'familyDetail',
                'partnerPreference',
                'member',
                'horoscopeBoxes',
                'followers',
                'following',
            ])->findOrFail($id);

            /* =====================================================
             | PROFILE PHOTO (GENDER BASED DEFAULT)
             ===================================================== */
            if ($targetProfile->profile_photo) {
                $profilePhoto = ($targetProfile->profile_photo);
            } else {
                $profilePhoto = strtolower($targetProfile->gender) === 'female'
                    ? ('storage/default_image/default_female.jpg')
                    : ('storage/default_image/default_male.jpg');
            }

            /* =====================================================
             | MEMBERSHIP INFO (VIEWER)
             ===================================================== */
            $sentInterestAllowed = $viewerMember?->sent_interest_allowed ?? 0;
            $sentInterestRemaining = $viewerMember?->sent_interest_remaining ?? 0;
            $profilesViewAllowed = $viewerMember?->profiles_view_allowed ?? 0;
            $profilesViewRemaining = $viewerMember?->profiles_view_remaining ?? 0;
            $messagesSentAllowed = $viewerMember?->messages_sent_allowed ?? 0;
            $messagesSentRemaining = $viewerMember?->messages_sent_remaining ?? 0;

            /* =====================================================
             | INTERACTIONS
             ===================================================== */
            $interactions = [
                'has_sent_interest' => false,
                'is_following' => false,
                'has_blocked' => false,
                'has_shortlisted' => false,
            ];

            if ($viewerProfileId) {
                $actions = ProfileAction::where('from_profile_id', $viewerProfileId)
                    ->where('to_profile_id', $targetProfile->id)
                    ->pluck('action_type')
                    ->flip();

                $hasSentInterest = \App\Models\Interest::where('sender_profile_id', $viewerProfileId)
                    ->where('receiver_profile_id', $targetProfile->id)
                    ->exists();

                $hasReported = ProfileReport::where('reported_by_profile_id', $viewerProfileId)
                    ->where('reported_profile_id', $targetProfile->id)
                    ->exists();

                $interactions = [
                    'has_sent_interest' => $hasSentInterest,
                    'is_following' => isset($actions['follow']),
                    'has_blocked' => isset($actions['block']),
                    'has_shortlisted' => isset($actions['shortlist']),
                    'has_reported' => $hasReported
                ];
            }

            /* =====================================================
             | RESPONSE DATA
             ===================================================== */
            $data = [
                'id' => $targetProfile->id,
                'member_id' => $targetProfile->member?->id,
                'member_no' => $targetProfile->member?->member_no,
                'interactions' => $interactions,
                'membership_name' => $targetProfile->member?->membership?->slug,
                'membership_plan' => $targetProfile->member?->membership?->savaran_plan,

                'current_user_membership' => [
                    'sent_interest_allowed' => $sentInterestAllowed,
                    'sent_interest_remaining' => $sentInterestRemaining,
                    'profiles_view_allowed' => $profilesViewAllowed,
                    'profiles_view_remaining' => $profilesViewRemaining,
                    'messages_sent_allowed' => $messagesSentAllowed,
                    'messages_sent_remaining' => $messagesSentRemaining,
                ],

                'followers_count' => $targetProfile->followers->count(),
                'following_count' => $targetProfile->following->count(),

                'basic' => [
                    'name' => $targetProfile->user?->name,
                    'gender' => $targetProfile->gender,
                    'age' => $targetProfile->age,
                    'dob' => $targetProfile->dob,
                    'marital_status' => $targetProfile->marital_status,
                    'physical_status' => $targetProfile->physical_status,
                    'profile_photo' => $profilePhoto,
                ],

                'partner' => $targetProfile->partnerPreference ? [
                    'about_partner' => $targetProfile->partnerPreference->about_partner,
                    'preferred_age' =>
                        $targetProfile->partnerPreference->preferred_age_min . ' - ' .
                        $targetProfile->partnerPreference->preferred_age_max,
                    'preferred_height' => $targetProfile->partnerPreference->preferred_height,
                    'education' => $targetProfile->partnerPreference->education,
                    'caste' => $targetProfile->partnerPreference->caste,
                    'marital_status' => $targetProfile->partnerPreference->marital_status,
                    'physical_status' => $targetProfile->partnerPreference->physical_status,
                    'body_type' => $targetProfile->partnerPreference->body_type,
                    'dosham' => $targetProfile->partnerPreference->dosham,
                    'type_of_dosham' => $targetProfile->partnerPreference->type_of_dosham,
                    'other_dosham' => $targetProfile->partnerPreference->other_dosham,
                    'profession' => $targetProfile->partnerPreference->profession,
                    'expectations' => $targetProfile->partnerPreference->expectations,
                ] : null,

                'location' => [
                    'native_place' => $targetProfile->native_place,
                    'country' => $targetProfile->country,
                    'state' => $targetProfile->state,
                    'city' => $targetProfile->city,
                    'address' => $targetProfile->address,
                    'postal_code' => $targetProfile->postal_code,
                    'mobile' => $targetProfile->mobile,
                    'alternate_number' => $targetProfile->alternate_number,
                    'landline' => $targetProfile->landline,
                    'current_city' => $targetProfile->current_city,
                ],

                'family' => $targetProfile->familyDetail ? [
                    'surname' => $targetProfile->familyDetail->surname,
                    'soveran_details' => $targetProfile->familyDetail->soveran_details,
                    'father_name' => $targetProfile->familyDetail->father_name,
                    'mother_name' => $targetProfile->familyDetail->mother_name,
                    'father_vangusam' => $targetProfile->familyDetail->father_vangusam,
                    'mother_vangusam' => $targetProfile->familyDetail->mother_vangusam,
                    'mother_occupation' => $targetProfile->familyDetail->mother_occupation,
                    'family_type' => $targetProfile->familyDetail->family_type,
                    'family_status' => $targetProfile->familyDetail->family_status,
                    'brothers_count' => $targetProfile->familyDetail->brothers_count,
                    'brothers_married' => $targetProfile->familyDetail->brothers_married,
                    'sisters_count' => $targetProfile->familyDetail->sisters_count,
                    'sisters_married' => $targetProfile->familyDetail->sisters_married,
                    'property_description' => $targetProfile->familyDetail->property_description,
                ] : null,

                'physical' => [
                    'height' => $targetProfile->height,
                    'weight' => $targetProfile->weight,
                    'complexion' => $targetProfile->complexion,
                    'blood_group' => $targetProfile->blood_group,
                    'eye_color' => $targetProfile->eye_color,
                    'hair_color' => $targetProfile->hair_color,
                    'body_type' => $targetProfile->body_type,
                    'body_art' => $targetProfile->body_art,
                ],

                'education' => [
                    'education' => $targetProfile->education,
                    'study_details' => $targetProfile->study_details,
                ],

                'career' => [
                    'occupation' => $targetProfile->occupation,
                    'income' => $targetProfile->income,
                    'work_location' => $targetProfile->work_location,
                    'career_profile' => $targetProfile->career_profile,
                    'earnings' => $targetProfile->earnings,
                    'income_amount' => $targetProfile->income_amount,
                ],

                'astronomic' => [
                    'rasi' => $targetProfile->rasi,
                    'star' => $targetProfile->star,
                    'lakknam' => $targetProfile->lakknam,
                    'padam' => $targetProfile->padam,
                    'tithi' => $targetProfile->tithi,
                    'paksha' => $targetProfile->paksha,
                    'dosham' => $targetProfile->dosham,
                    'type_of_dosham' => $targetProfile->type_of_dosham,
                    'other_dosham' => $targetProfile->other_dosham,
                    'horoscope_matching' => $targetProfile->horoscope_matching,
                    'directional_balance' => $targetProfile->directional_balance,
                    'date_of_birth' => $targetProfile->date_of_birth ?? $targetProfile->dob,
                    'day_of_birth' => $targetProfile->day_of_birth,
                    'birth_time' => $targetProfile->birth_time,
                    'birth_city' => $targetProfile->birth_city,
                    'year' => $targetProfile->year,
                    'month' => $targetProfile->month,
                    'day' => $targetProfile->day,
                ],

                'images' => [],
                'horoscope_boxes' => $targetProfile->horoscopeBoxes
                    ->map(fn($box) => [
                        'id' => $box->id,
                        'box_number' => $box->box_number,
                        'item_number' => $box->item_number,
                        'type' => $box->type,
                        'value' => $box->value,
                    ])
                    ->groupBy('box_number'),
            ];

            return ApiResponse::success('Profile data', $data);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return ApiResponse::error('Profile not found', null, 404);
        } catch (\Throwable $e) {
            return ApiResponse::error('Failed to retrieve profile', $e->getMessage(), 500);
        }
    }


    // private function fetchFullProfile($id)
    // {
    //     $profile = Member::with([
    //         'membership',
    //         'profile' => function ($q) {
    //             $q->with([
    //                 'user',
    //                 'familyDetail',
    //                 'partnerPreference',
    //                 'photos',
    //                 'horoscopeBoxes',
    //             ])->withCount([
    //                 'followers',
    //                 'following',
    //                 'interestsSent',
    //                 'interestsReceived',
    //                 'blockedProfiles',
    //                 'shortlistedProfiles',
    //             ]);
    //         }
    //     ])->where('profile_id', $id)
    //         ->where('status', 'active')        // ✅ ONLY ACTIVE
    //         ->latest('created_at')                   // ✅ LATEST ACTIVE
    //         ->first();


    //     if (!$profile) {
    //         return ApiResponse::error('No active membership found', null, 404);
    //     }

    //     // 🔹 APPEND INTERACTION STATUS
    //     $authUser = Auth::user();
    //     if ($authUser && $authUser->profile && $profile->profile) {
    //         $viewerProfileId = $authUser->profile->id;
    //         $viewedProfileId = $profile->profile->id;

    //         $isFollowing = \App\Models\ProfileAction::where('from_profile_id', $viewerProfileId)
    //             ->where('to_profile_id', $viewedProfileId)
    //             ->where('action_type', 'follow')
    //             ->exists();

    //         $isShortlisted = \App\Models\ProfileAction::where('from_profile_id', $viewerProfileId)
    //             ->where('to_profile_id', $viewedProfileId)
    //             ->where('action_type', 'shortlist')
    //             ->exists();

    //         // Append to the response structure securely
    //         $profile->is_following = $isFollowing;
    //         $profile->is_shortlisted = $isShortlisted;


    //         // Also append to the inner 'profile' object just in case frontend checks there
    //         $profile->profile->is_following = $isFollowing;
    //         $profile->profile->is_shortlisted = $isShortlisted;
    //         $profile->profile->is_following = $isFollowing;
    //         $profile->profile->is_shortlisted = $isShortlisted;
    //     }


    //     return ApiResponse::success('Record found', $profile);
    // }



    private function fetchFullProfile($id)
    {
        $profile = Profile::with([
            'user',
            'familyDetail',
            'partnerPreference',
            'photos',
            'horoscopeBoxes',
            'activeMember.membership'
        ])->withCount([
                    'followers',
                    'following',
                    'interestsSent',
                    'interestsReceived',
                    'blockedProfiles',
                    'shortlistedProfiles',
                ])
                ->where('id', $id)
                ->first();

        if (!$profile) {
            return ApiResponse::error('Profile not found', null, 404);
        }

        // 🔹 INTERACTION STATUS
        $authUser = Auth::user();
        if ($authUser && $authUser->profile) {

            $viewerProfileId = $authUser->profile->id;
            $viewedProfileId = $profile->id;

            $profile->is_following = ProfileAction::where(
                'from_profile_id',
                $viewerProfileId
            )->where('to_profile_id', $viewedProfileId)
                ->where('action_type', 'follow')
                ->exists();

            $profile->is_shortlisted = ProfileAction::where(
                'from_profile_id',
                $viewerProfileId
            )->where('to_profile_id', $viewedProfileId)
                ->where('action_type', 'shortlist')
                ->exists();
        }

        /*
    |--------------------------------------------------------------------------
    | 🔥 SAFE WRAP (NO RECURSION)
    |--------------------------------------------------------------------------
    */

        $member = $profile->activeMember;

        if (!$member) {
            $member = new Member();
        }

        // convert profile to array to prevent circular reference
        $profileArray = $profile->toArray();

        // remove nested member inside profile to stop recursion
        unset($profileArray['member']);

        $memberArray = $member->toArray();

        // attach profile manually
        $memberArray['profile'] = $profileArray;

        return ApiResponse::success('Record found', $memberArray);
    }

    public function update(Request $request, $id)
    {
        try {
            $this->authorize('update', Member::class);

            // Load member + profile
            $member = Member::with('profile')->findOrFail($id);
            $profile = $member->profile;

            // Validation
            $validator = Validator::make($request->all(), $this->updateRules);

            $validator->after(function ($validator) use ($request, $id) {

                $phone = $request->phone;
                $gender = $request->gender;

                if (!$phone || !$gender)
                    return;

                $exists = User::where('phone', $phone)
                    ->where('id', '!=', $id)
                    ->whereHas('profile', function ($q) use ($gender) {
                        $q->where('gender', $gender);
                    })
                    ->exists();

                if ($exists) {
                    $validator->errors()->add('phone', 'This phone already used for this gender.');
                }
            });

            $validatedData = $validator->validate();

            Log::info('ACTION: Updating record', [
                'user_id' => Auth::id(),
                'profile_id' => $id,
                'validated_data' => $validatedData,
            ]);

            $extraData = [];

            /*
            |----------------------------------------------------------
            | Profile Photo Upload
            |----------------------------------------------------------
            */
            if ($request->hasFile('profile_photo')) {

                $file = $request->file('profile_photo');

                $fileName = "profile_" . now()->format('Y_m_d_H_i_s') . "_" . rand(10000, 99999) .
                    "." . $file->getClientOriginalExtension();

                $path = $file->storeAs(
                    "profiles/" . now()->format('Y') . "/" . now()->format('m'),
                    $fileName,
                    'public'
                );

                $extraData['profile_photo'] = "storage/{$path}";
                $extraData['profile_photo_url'] = url("storage/{$path}");
            } elseif ($request->boolean('remove_profile_photo')) {
                $extraData['profile_photo'] = null;
                $extraData['profile_photo_url'] = null;
            }

            /*
            |----------------------------------------------------------
            | Horoscope File Upload
            |----------------------------------------------------------
            */
            if ($request->hasFile('horoscope_file')) {

                $file = $request->file('horoscope_file');

                $fileName = "horoscope_" . now()->format('Y_m_d_H_i_s') . "_" . rand(10000, 99999) .
                    "." . $file->getClientOriginalExtension();

                $path = $file->storeAs(
                    "horoscope_files/" . now()->format('Y') . "/" . now()->format('m'),
                    $fileName,
                    'public'
                );

                $extraData['horoscope_file'] = "storage/{$path}";
                $extraData['horoscope_file_url'] = url("storage/{$path}");
            }

            // Merge file data
            $validatedData = array_merge($validatedData, $extraData);

            /*
            |----------------------------------------------------------
            | UPDATE PROFILE
            |----------------------------------------------------------
            */
            $updatedProfile = $this->profileService->update($profile->id, $validatedData);

            /*
            |----------------------------------------------------------
            | UPDATE USER
            |----------------------------------------------------------
            */
            $user = User::find($profile->user_id);

            if ($user) {
                $user->update([
                    'name' => $validatedData['name'] ?? $user->name,
                    'email' => $validatedData['email'] ?? $user->email,
                    'phone' => $validatedData['phone'] ?? $user->phone,
                ]);
            }

            /*
            |------------------------------------------------------------------
            | 🔥 MEMBERSHIP CHANGE → MEMBER NO GENERATE ONLY (NOT AUTO ACTIVE)
            |------------------------------------------------------------------
            */
            if (!empty($validatedData['membership_type'])) {

                // Fetch membership
                $membership = $this->membershipService->list([
                    'slug' => $validatedData['membership_type'],
                    'status' => 'active',
                ])->first();

                if ($membership) {

                    $member = Member::with('profile')
                        ->where('profile_id', $profile->id)
                        ->first();

                    if ($member) {

                        $oldMembershipId = $member->membership_id;
                        $newMembershipId = $membership->id;

                        // Update membership id
                        $member->membership_id = $newMembershipId;

                        /*
                        |----------------------------------------------------------
                        | DEFAULT MEMBERSHIP
                        |----------------------------------------------------------
                        */
                        if ($membership->slug === 'default') {

                            $member->member_no = 'Temporary';
                            $member->status = 'inactive'; // always inactive

                        } else {

                            /*
                            |----------------------------------------------------------
                            | PAID MEMBERSHIP
                            |----------------------------------------------------------
                            */

                            // Generate member no if needed
                            if (
                                $oldMembershipId !== $newMembershipId ||
                                $member->member_no === 'Temporary' ||
                                empty($member->member_no)
                            ) {
                                $member->member_no = $this->generateMemberNo($member);
                            }

                            // ❗ IMPORTANT:
                            // DO NOT AUTO ACTIVATE HERE
                            // Admin activateMember() method la mattum active aaganum
                            if ($member->status !== 'active') {
                                $member->status = 'inactive';
                            }
                        }

                        $member->save();
                    }
                }
            }

            $this->profileCompletionService->recalculateMemberCompletion($member->id);

            return ApiResponse::success('Profile updated successfully', $updatedProfile);
        } catch (\Exception $e) {

            Log::error('Failed to update profile', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return ApiResponse::error('Failed to update profile', $e->getMessage(), 500);
        }
    }

    public function getByUserId($userId, Request $request)
    {
        try {
            // Fetch the profile by user ID
            $profile = Profile::with($request->get('with', [
                'familyDetail',
                'partnerPreference',
                'photo',
            ]))->where('user_id', $userId)->firstOrFail();

            // Authorize with the model instance
            $this->authorize('view', $profile);

            Log::info('ACTION: Fetching profile by user ID', [
                'admin_user_id' => Auth::id(),
                'user_id' => $userId,
            ]);

            return ApiResponse::success('Profile fetched successfully', $profile);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return ApiResponse::error('Unauthorized', $e->getMessage(), 403);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return ApiResponse::error('Profile not found', $e->getMessage(), 404);
        } catch (\Throwable $e) {
            Log::error('Failed to fetch profile by user ID', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return ApiResponse::error('Failed to fetch profile', $e->getMessage(), 500);
        }
    }

    public function store(Request $request)
    {
        try {

            $this->authorize('create', Member::class);

            // 🔹 VALIDATION
            $validator = Validator::make($request->all(), $this->storeRules);

            $validator->after(function ($validator) use ($request) {

                $phone = $request->phone;
                $gender = $request->gender;

                if (!$phone || !$gender)
                    return;

                $exists = User::where('phone', $phone)
                    ->whereHas('profile', function ($q) use ($gender) {
                        $q->where('gender', $gender);
                    })
                    ->exists();

                if ($exists) {
                    $validator->errors()->add('phone', 'This phone already used for this gender.');
                }
            });

            $validatedData = $validator->validate();

            $extraData = [];

            /*
            |--------------------------------------------------------------------------
            | 📸 PROFILE PHOTO UPLOAD
            |--------------------------------------------------------------------------
            */
            if (
                !empty($validatedData['profile_photo']) &&
                $validatedData['profile_photo'] instanceof \Illuminate\Http\UploadedFile
            ) {
                $file = $validatedData['profile_photo'];

                $fileName = "profile_" . now()->format('Y_m_d_H_i_s') . "_" . rand(10000, 99999)
                    . "." . $file->getClientOriginalExtension();

                $path = $file->storeAs("profiles/" . now()->format('Y/m'), $fileName, 'public');

                $extraData['profile_photo'] = "storage/{$path}";
                $extraData['profile_photo_url'] = url("storage/{$path}");
            }

            /*
            |--------------------------------------------------------------------------
            | 📄 HOROSCOPE FILE UPLOAD
            |--------------------------------------------------------------------------
            */
            if (
                !empty($validatedData['horoscope_file']) &&
                $validatedData['horoscope_file'] instanceof \Illuminate\Http\UploadedFile
            ) {
                $file = $validatedData['horoscope_file'];

                $fileName = "horoscope_" . now()->format('Y_m_d_H_i_s') . "_" . rand(10000, 99999)
                    . "." . $file->getClientOriginalExtension();

                $path = $file->storeAs("horoscope_files/" . now()->format('Y/m'), $fileName, 'public');

                $extraData['horoscope_file'] = "storage/{$path}";
                $extraData['horoscope_file_url'] = url("storage/{$path}");
            }

            $validatedData = array_merge($validatedData, $extraData);

            /*
            |--------------------------------------------------------------------------
            | 🔥 DB TRANSACTION
            |--------------------------------------------------------------------------
            */
            $result = DB::transaction(function () use ($validatedData) {

                /*
                |--------------------------------------------------------------------------
                | 1️⃣ CREATE USER
                |--------------------------------------------------------------------------
                */
                $user = $this->userService->create([
                    'name' => $validatedData['name'],
                    'email' => $validatedData['email'],
                    'phone' => $validatedData['phone'] ?? null,
                    'password' => bcrypt($validatedData['password']),
                    'role_id' => 4,
                ]);

                /*
                |--------------------------------------------------------------------------
                | 2️⃣ CREATE PROFILE
                |--------------------------------------------------------------------------
                */
                $validatedData['user_id'] = $user->id;

                $registrationMode = $validatedData['registration_mode'] ?? 'online';
                $validatedData['registration_mode'] = $registrationMode;

                $profile = $this->profileService->create($validatedData);

                $user->update([
                    'is_profile_complete' => 1,
                ]);

                /*
                |--------------------------------------------------------------------------
                | 3️⃣ FETCH MEMBERSHIP
                |--------------------------------------------------------------------------
                */
                $membership = null;

                if (!empty($validatedData['membership_type'])) {
                    $membership = $this->membershipService->list([
                        'slug' => $validatedData['membership_type'],
                        'status' => 'active',
                    ])->first();
                }

                $member = null;

                /*
                |--------------------------------------------------------------------------
                | 4️⃣ CREATE MEMBER
                |--------------------------------------------------------------------------
                */
                if ($membership) {

                    $member = $this->membersService->create([
                        'profile_id' => $profile->id,
                        'membership_id' => $membership->id,
                        'start_date' => now()->toDateString(),
                        'end_date' => now()->addMonths(6)->toDateString(),

                        // limits
                        'profiles_view_allowed' => $membership->profiles_view_allowed ?? 0,
                        'profiles_view_remaining' => $membership->profiles_view_allowed ?? 0,
                        'interest_received_allowed' => $membership->interest_received_allowed ?? 0,
                        'sent_interest_allowed' => $membership->sent_interest_allowed ?? 0,
                        'sent_interest_remaining' => $membership->sent_interest_allowed ?? 0,
                        'phone_numbers_allowed' => $membership->phone_numbers_allowed ?? 0,

                        'send_reminder' => false,
                        'auto_renewal' => false,

                        // 🔥 STATUS LOGIC
                        'status' => $registrationMode === 'offline'
                            ? 'active'
                            : 'inactive',

                        'member_no' => null,
                    ]);

                    // 🔥 Reload with profile (IMPORTANT for gender)
                    $member = Member::with('profile')->findOrFail($member->id);

                    /*
                    |--------------------------------------------------------------------------
                    | 🔥 MEMBER NUMBER LOGIC (FINAL FIX)
                    |--------------------------------------------------------------------------
                    */
                    if ($registrationMode === 'offline') {

                        // ✅ OFFLINE → generate immediately
                        $member->member_no = $this->generateMemberNo($member);

                    } else {

                        // ❌ ONLINE → temporary
                        $member->member_no = 'Temporary';
                        $member->save();
                    }
                }

                return compact('profile', 'member');
            });
            if (!empty($result['member']?->id)) {
                $this->profileCompletionService->recalculateMemberCompletion($result['member']->id);
            }

            return ApiResponse::success('Profile created successfully', $result);

        } catch (\Throwable $e) {

            Log::error('Create failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return ApiResponse::error('Failed to create profile', $e->getMessage(), 500);
        }
    }

    public function incompleteMembers(Request $request)
    {
        try {
            $perPage = (int) $request->input('per_page', 10);
            $filters = $request->only(['member_no', 'user_name', 'phone']);

            $result = $this->profileCompletionService->getIncompleteMembers($perPage, $filters);

            return ApiResponse::success('Incomplete members fetched successfully', $result);
        } catch (\Throwable $e) {
            Log::error('Failed to fetch incomplete members', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return ApiResponse::error('Failed to fetch incomplete members', $e->getMessage(), 500);
        }
    }

    public function blockMember($id)
    {
        // $this->authorize('update', $this->policyModel);

        try {
            $member = $this->membersService->get($id);
            if (!$member) {
                return ApiResponse::error('Member not found.', 404);
            }

            $updatedMember = $this->membersService->update($id, [
                'blocked_by_admin' => true,
                'status' => 'inactive'
            ]);

            return ApiResponse::success('Member blocked successfully.', $updatedMember);
        } catch (\Throwable $e) {
            logger()->error('Member Block Failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return ApiResponse::error('An unexpected error occurred while blocking the member.', 500);
        }
    }

    public function unblockMember($id)
    {
        // $this->authorize('update', $this->policyModel);

        try {
            $member = $this->membersService->get($id);
            if (!$member) {
                return ApiResponse::error('Member not found.', 404);
            }

            $updatedMember = $this->membersService->update($id, [
                'blocked_by_admin' => false,
                'status' => 'active'
            ]);

            return ApiResponse::success('Member unblocked successfully.', $updatedMember);
        } catch (\Throwable $e) {
            logger()->error('Member Unblock Failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return ApiResponse::error('An unexpected error occurred while unblocking the member.', 500);
        }
    }

    public function checkMobileNumber(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'phone' => 'required|digits:10',
            ]);

            if ($validator->fails()) {
                return ApiResponse::error('Validation failed', $validator->errors(), 422);
            }

            $phone = $request->phone;

            // Check if phone exists for MALE
            $maleExists = User::where('phone', $phone)
                ->whereHas('profile', function ($q) {
                    $q->where('gender', 'male');
                })
                ->exists();

            // Check if phone exists for FEMALE
            $femaleExists = User::where('phone', $phone)
                ->whereHas('profile', function ($q) {
                    $q->where('gender', 'female');
                })
                ->exists();

            // If exists in ANY gender
            if ($maleExists || $femaleExists) {
                return ApiResponse::error(
                    'Mobile number already exists.',
                    [
                        'phone' => $phone,
                        'available' => false,
                        'used_by_male' => $maleExists,
                        'used_by_female' => $femaleExists,
                    ],
                    409
                );
            }

            return ApiResponse::success('Mobile number is available', [
                'phone' => $phone,
                'available' => true,
                'used_by_male' => false,
                'used_by_female' => false,
            ]);
        } catch (\Throwable $e) {
            logger()->error('Mobile Number Check Failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return ApiResponse::error('An unexpected error occurred while checking the mobile number.', 500);
        }
    }

    public function renewMembership(Request $request, $memberId)
    {
        $validated = $request->validate([
            'registration_mode' => 'required|in:offline,online',
            'plan_type' => 'required|exists:memberships,slug',
        ]);

        DB::beginTransaction();

        try {

            // 1️⃣ Load current member + profile + user
            $member = Member::with('profile.user')->findOrFail($memberId);
            $profile = $member->profile;

            // ❌ Prevent admin renewal
            if ($profile->user->role_id === 1) {
                return ApiResponse::error('Admin membership cannot be renewed', 403);
            }

            // 2️⃣ Fetch new membership plan
            $membership = Membership::where('slug', $validated['plan_type'])->firstOrFail();

            /*
            |--------------------------------------------------------------------------
            | 🔥 STEP 1 — EXPIRE OLD MEMBER
            |--------------------------------------------------------------------------
            */
            $member->update([
                'status' => 'expired'
            ]);

            /*
            |--------------------------------------------------------------------------
            | 🔥 STEP 2 — CREATE NEW MEMBER RECORD
            |--------------------------------------------------------------------------
            */
            $newMember = Member::create([
                'profile_id' => $profile->id,
                'membership_id' => $membership->id,
                'start_date' => now(),
                'end_date' => now()->addDays($membership->duration_days),

                // 🔹 status
                'status' => $validated['registration_mode'] === 'offline'
                    ? 'active'
                    : 'inactive',

                // PROFILE VIEW
                'profiles_view_allowed' => $membership->profiles_view_allowed ?? 0,
                'profiles_view_remaining' => $membership->profiles_view_allowed ?? 0,

                // INTEREST
                'sent_interest_allowed' => $membership->sent_interest_allowed ?? 0,
                'sent_interest_remaining' => $membership->sent_interest_allowed ?? 0,

                // MESSAGES
                'messages_sent_allowed' => $membership->messages_sent_allowed ?? 0,
                'messages_sent_remaining' => $membership->messages_sent_allowed ?? 0,

                'isRenewed' => true,
                'send_reminder' => false,
                'auto_renewal' => false,
            ]);

            /*
            |--------------------------------------------------------------------------
            | 🔥 STEP 3 — MEMBER NUMBER LOGIC
            |--------------------------------------------------------------------------
            */
            if ($validated['registration_mode'] === 'offline') {

                // 🔹 Gender prefix
                $prefix = strtolower($profile->gender) === 'female' ? 'Female' : 'Male';
                // 🔒 Lock table row to prevent duplicate numbers
                $gender = strtolower($profile->gender);
                $prefix = $gender === 'female' ? 'Female' : 'Male';

                $lastPrefix = Member::whereNotNull('prefix_id')
                    ->lockForUpdate()
                    ->max('prefix_id');

                $lastPrefix = (int) $lastPrefix;

                // first value
                if ($lastPrefix === 0) {
                    $nextPrefix = $gender === 'male' ? 1000 : 5000;
                } else {
                    $nextPrefix = $lastPrefix + 1;
                }

                // assign
                $newMember->prefix_id = $nextPrefix;
                $newMember->member_no = $prefix . $nextPrefix;

            } else {
                // 🌐 ONLINE → temporary until approval
                $newMember->member_no = 'Temporary';
            }

            $newMember->save();

            /*
            |--------------------------------------------------------------------------
            | 🔥 STEP 4 — UPDATE PROFILE REGISTRATION MODE
            |--------------------------------------------------------------------------
            */
            $profile->update([
                'registration_mode' => $validated['registration_mode']
            ]);

            DB::commit();

            /*
            |--------------------------------------------------------------------------
            | 🔥 FINAL RESPONSE
            |--------------------------------------------------------------------------
            */
            return ApiResponse::success('Membership renewed successfully', [
                'member' => $newMember->load(['profile.user', 'membership']),
                'old_member_id' => $member->id,
                'expired_status' => 'expired',
                'user_name' => $profile->user->name
            ]);

        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Renew membership failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return ApiResponse::error('Failed to renew membership', $e->getMessage(), 500);
        }
    }

    private function generateMemberNo(Member $member): string
    {
        $gender = strtolower($member->profile->gender); // male / female
        $prefix = ucfirst($gender); // Male / Female

        DB::beginTransaction();

        try {

            /* 🔥 gender-wise highest prefix_id */
            $lastPrefix = Member::whereHas('profile', function ($q) use ($gender) {
                $q->where('gender', $gender);
            })
                ->whereNotNull('prefix_id')
                ->lockForUpdate()
                ->max('prefix_id');

            $lastPrefix = (int) $lastPrefix;

            // First member start value
            if ($lastPrefix === 0) {
                $nextPrefix = $gender === 'male' ? 1000 : 5000;
            } else {
                $nextPrefix = $lastPrefix + 1;
            }

            /* 🔥 SAVE */
            $member->prefix_id = $nextPrefix;
            $member->member_no = $prefix . $nextPrefix;
            $member->save();

            DB::commit();

            return $member->member_no;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateSavaran(Request $request)
    {
        $request->validate([
            'savaran' => 'required|integer|min:1'
        ]);

        $profile = auth()->user()->profile;

        $profile->family_detail->update([
            'soveran_details' => $request->savaran
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Savaran updated successfully'
        ]);
    }

    public function deactivateSelf(Request $request)
    {
        try {
            $user = $request->user();

            if (!$user) {
                return ApiResponse::error('Unauthenticated', null, 401);
            }

            $profile = $user->profile;
            if (!$profile) {
                return ApiResponse::error('Profile not found', null, 404);
            }

            $member = Member::where('profile_id', $profile->id)
                ->latest('id')
                ->first();

            if (!$member) {
                return ApiResponse::error('Member record not found', null, 404);
            }

            $member->update([
                'is_deactivated' => true,
                'status' => 'inactive',
                'active' => false,
            ]);

            // Force logout from all devices immediately
            $user->tokens()->delete();

            return ApiResponse::success('Account deactivated successfully', [
                'member_id' => $member->id,
                'is_deactivated' => true,
            ]);
        } catch (\Throwable $e) {
            Log::error('Failed to deactivate account', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return ApiResponse::error('Failed to deactivate account', $e->getMessage(), 500);
        }
    }


    public function activateMember(Request $request, $id)
    {
        try {

            $member = Member::with('profile')->findOrFail($id);

            // generate member number if temporary
            if ($member->member_no === 'Temporary') {
                $member->member_no = $this->generateMemberNo($member);
            }

            $member->status = 'active';
            $member->is_deactivated = false;

            $member->save();

            // SEND SMS NOTIFICATION FOR ACTIVATION
            try {
                $mobile = $member->profile->user->phone ?? $member->profile->mobile ?? $member->profile->alternate_number ?? null;
                Log::info('Activation Action: Executing SMS Logic', ['mobile' => $mobile, 'member_id' => $member->id]);
                if ($mobile) {
                    $rawPhone = preg_replace('/[^0-9]/', '', $mobile);
                    // Standardize to 12 digits (91 + 10 digits)
                    if (strlen($rawPhone) === 10) {
                        $rawPhone = '91' . $rawPhone;
                    }
                    
                    $smsService = app(\Bits\Package\Services\SmsGatewayHubService::class);
                    $templateId = env('SMS_TEMPLATE_ACCOUNT_ACTIVATION', '1307161831924273552');
                    
                    // Standard activation message
                    $userName = $member->profile->user->name ?? 'User';
                    $text = "Dear {$userName}, Your account profile is successfully Activated. By -SSANPM";
                    
                    $smsResponse = $smsService->send($rawPhone, $templateId, [
                        'text' => $text,
                        'var1' => $userName,
                        'var2' => $member->member_no ?? ''
                    ]);
                    
                    Log::info('Activation SMS response', [
                        'response' => $smsResponse,
                        'phone' => $rawPhone,
                        'template_id' => $templateId,
                        'text_sent' => $text
                    ]);
                } else {
                    Log::warning('Activation SMS: Member missing mobile number', ['member_id' => $member->id]);
                }
            } catch (\Throwable $snsError) {
                Log::error('Failed to send SMS on activation', [
                    'member_id' => $member->id,
                    'error' => $snsError->getMessage()
                ]);
            }

            return ApiResponse::success('Member activated successfully', $member);

        } catch (\Throwable $e) {

            return ApiResponse::error(
                'Failed to activate member',
                $e->getMessage(),
                500
            );
        }
    }

    public function adminReactivateMember(Request $request, $id)
    {
        try {
            $this->authorize('update', Member::class);

            $member = Member::findOrFail($id);

            if (!(bool) $member->is_deactivated) {
                return ApiResponse::error('Member is already active', null, 422);
            }

            $member->update([
                'status' => 'active',
                'active' => true,
                'is_deactivated' => false,
            ]);

            Log::info('ACTION: Member reactivated by admin dashboard', [
                'admin_user_id' => Auth::id(),
                'member_id' => $id,
            ]);

            return ApiResponse::success('Member reactivated successfully', $member);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return ApiResponse::error('Unauthorized', $e->getMessage(), 403);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return ApiResponse::error('Member not found', $e->getMessage(), 404);
        } catch (\Throwable $e) {
            Log::error('Failed to reactivate member by admin', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return ApiResponse::error('Failed to reactivate member', $e->getMessage(), 500);
        }
    }

    public function getByRegistrationMode(Request $request, $mode = 'online')
    {
        try {

            // ❌ other modes block
            if ($mode !== 'online') {
                return ApiResponse::error('Invalid mode', 'Only online mode allowed', 422);
            }

            // 🔥 ONLINE + INACTIVE ONLY (EXCLUDING DEACTIVATED)
            $query = Member::with([
                'profile',
                'profile.user',
                'membership'
            ])
                ->whereHas('profile', function ($q) {
                    $q->where('registration_mode', 'online');
                })
                ->where('status', 'inactive') // activation pending users
                ->where('is_deactivated', 0); // exclude deactivated members
                
            $this->applyDuplicateFilter($query);
            
            $query->latest();

            // Filter by name
            if ($request->has('member_no') && !empty($request->member_no)) {
                $member_no = $request->member_no;
                $query->where('member_no', 'like', "%{$member_no}%");
            }

            if ($request->has('name') && !empty($request->name)) {
                $name = $request->name;
                $query->whereHas('profile.user', function ($q) use ($name) {
                    $q->where('name', 'like', "%{$name}%");
                });
            }

            // Filter by gender
            if ($request->has('profile_gender') && !empty($request->profile_gender)) {
                $profile_gender = $request->profile_gender;
                $query->whereHas('profile', function ($q) use ($profile_gender) {
                    $q->where('gender', $profile_gender);
                });
            }

            // Pagination
            $perPage = $request->input('per_page', 10);
            $profiles = $query->paginate($perPage);

            $data = collect($profiles->items())->map(function ($p) {
                return [
                    'id' => $p->id,
                    'name' => $p->profile->user->name ?? '',
                    'member_no' => $p->member_no ?? '',
                    'profile_photo' => $p->profile?->profile_photo
                        ? $p->profile->profile_photo
                        : (strtolower($p->profile?->gender) === 'female'
                            ? 'storage/default_image/default_female.jpg'
                            : 'storage/default_image/default_male.jpg'),
                    'profile_gender' => $p->profile->gender === 'male' ? 'Male' : ($p->profile->gender === 'female' ? 'Female' : $p->profile->gender),
                    'registration_mode' => $p->profile->registration_mode ?? '',
                    'profiles_used' => $p->profiles_view_remaining,
                    'membership_slug' => $p->membership->slug ?? '',
                    'phone' => $p->profile->user->phone ?? '',
                    'is_renewed' => $p->isRenewed,
                    'created_at' => $p->created_at->format('d-m-Y'),
                    'status' => $p->status,
                ];
            });

            return ApiResponse::success(
                'Online inactive members fetched',
                [
                    'current_page' => $profiles->currentPage(),
                    'per_page' => $profiles->perPage(),
                    'total' => $profiles->total(),
                    'last_page' => $profiles->lastPage(),
                    'data' => $data,
                ]
            );
        } catch (\Throwable $e) {
            return ApiResponse::error('Failed to fetch profiles', $e->getMessage(), 500);
        }
    }


    public function oldIdRenewedMembers(Request $request)
    {
        try {
            $perPage = (int) $request->input('per_page', 10);

            $query = Member::where('status', 'expired');
            
            $this->applyDuplicateFilter($query);

            if ($request->filled('member_no')) {
                $query->where('member_no', 'like', '%' . $request->member_no . '%');
            }

            $name = $request->input('name', $request->input('user_name'));
            if (!empty($name)) {
                $query->whereHas('profile.user', function ($userQuery) use ($name) {
                    $userQuery->where('name', 'like', '%' . $name . '%');
                });
            }

            if ($request->filled('phone')) {
                $query->whereHas('profile.user', function ($userQuery) use ($request) {
                    $userQuery->where('phone', 'like', '%' . $request->phone . '%');
                });
            }

            $members = $query
                ->with(['profile', 'profile.user', 'membership'])
                ->latest()
                ->paginate($perPage);

            $data = collect($members->items())->map(function ($m) {
                return [
                    'id' => $m->id,
                    'name' => $m->profile->user->name ?? null,
                    'profile_photo' => $m->profile?->profile_photo
                        ? $m->profile->profile_photo
                        : (strtolower($m->profile?->gender) === 'female'
                            ? 'storage/default_image/default_female.jpg'
                            : 'storage/default_image/default_male.jpg'),
                    'profile_gender' => $m->profile->gender ?? null,
                    'registration_mode' => $m->profile->registration_mode ?? null,
                    'membership_slug' => $m->membership->slug ?? null,
                    'profile_marital_status' => $m->profile->marital_status ?? null,
                    'member_no' => $m->member_no ?? null,
                    'phone' => $m->profile->user->phone ?? null,
                    'profiles_used' => $m->profiles_view_remaining ?? 0,
                    'created_at' => $m->created_at->format('Y-m-d'),
                    'is_reported' => $m->profile->is_reported ?? false,
                    'status' => $m->status,
                ];
            });

            return ApiResponse::success(
                'Old ID Renewed members fetched successfully',
                [
                    'current_page' => $members->currentPage(),
                    'per_page' => $members->perPage(),
                    'total' => $members->total(),
                    'last_page' => $members->lastPage(),
                    'data' => $data,
                ]
            );
        } catch (\Throwable $e) {
            return ApiResponse::error('Failed to fetch old ID renewed members', $e->getMessage(), 500);
        }
    }

    public function matchedMembers(Request $request, $memberId)
    {
        try {
            // Validate
            $request->validate([
                'is_matched' => 'required|boolean',
            ]);

            // Find member
            $member = Member::findOrFail($memberId);

            // Update field
            $member->is_matched = $request->is_matched;
            $member->save();

            return ApiResponse::success('Match status updated successfully', $member);
        } catch (\Throwable $e) {
            return ApiResponse::error('Failed to update match status', $e->getMessage(), 500);
        }
    }

    public function pendingRenewalMembers(Request $request)
    {
        try {
            $today = now()->toDateString();
            $perPage = $request->input('per_page', 10);

            $query = Member::whereDate('end_date', '<', $today) // expired
                ->where('membership_expired', false) // not renewed yet
                ->with(['profile', 'profile.user', 'membership']);

            $this->applyDuplicateFilter($query);

            // Filters
            if ($request->has('member_id') && !empty($request->member_id)) {
                $query->where('member_no', 'like', '%' . $request->member_id . '%');
            }

            if ($request->has('name') && !empty($request->name)) {
                $query->whereHas('profile.user', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->name . '%');
                });
            }

            if ($request->has('profile_phone') && !empty($request->profile_phone)) {
                $query->whereHas('profile.user', function ($q) use ($request) {
                    $q->where('phone', 'like', '%' . $request->profile_phone . '%');
                });
            }

            $members = $query->paginate($perPage);

            $data = collect($members->items())->map(function ($m) {
                return [
                    'id' => $m->id,
                    'member_id' => $m->member_no,
                    'name' => $m->profile->user->name ?? null,
                    'profile_photo' => $m->profile?->profile_photo
                        ? $m->profile->profile_photo
                        : (strtolower($m->profile?->gender) === 'female'
                            ? 'storage/default_image/default_female.jpg'
                            : 'storage/default_image/default_male.jpg'),
                    'profile_gender' => $m->profile->gender ?? null,
                    'phone' => $m->profile->user->phone ?? null,
                    'registration_mode' => $m->profile->registration_mode ?? null,
                    'membership_slug' => $m->membership->slug ?? null,
                    'profile_marital_status' => $m->profile->marital_status ?? null,
                    'profiles_used' => $m->profiles_view_remaining ?? 0,
                    'membership_end_date' => \Carbon\Carbon::parse($m->end_date)->format('d-m-Y'),
                    'expired_days_ago' => now()->diffInDays($m->end_date),
                    'is_renewed' => $m->isRenewed,
                    'created_at' => \Carbon\Carbon::parse($m->created_at)->format('d-m-Y'),
                    'status' => $m->status,
                ];
            });

            return ApiResponse::success('Expired members fetched successfully', [
                'current_page' => $members->currentPage(),
                'per_page' => $members->perPage(),
                'total' => $members->total(),
                'last_page' => $members->lastPage(),
                'data' => $data,
            ]);
        } catch (\Throwable $e) {
            return ApiResponse::error('Failed to fetch expired members', $e->getMessage(), 500);
        }
    }

    public function reduceProfileAllowedCount(Request $request)
    {
        try {
            $memberId = $request->input('member_id');
            if (!$memberId) {
                return ApiResponse::error('Member ID required', null, 400);
            }

            $member = Member::findOrFail($memberId);
            $member = Member::findOrFail($memberId);

            $oldRemaining = (int) ($member->profiles_view_remaining ?? 0);

            if ($oldRemaining <= 0) {
                return ApiResponse::error('Profile view limit reached', null, 403);
            }
            if ($oldRemaining <= 0) {
                return ApiResponse::error('Profile view limit reached', null, 403);
            }

            $newRemaining = $oldRemaining - 1;
            $newRemaining = $oldRemaining - 1;

            $member->update([
                'profiles_view_remaining' => $newRemaining
            ]);

            return ApiResponse::success('Profile view reduced', [
                'profiles_view_remaining' => $newRemaining,
                'profiles_view_allowed' => (int) ($member->profiles_view_allowed ?? 0)
            ]);
        } catch (\Throwable $e) {
            return ApiResponse::error('Failed to reduce profile view', null, 500);
        }
    }
    public function deleteMemberList(Request $request)
    {
        try {

            $currentUser = $request->user();

            // 1️⃣ Check Permission (Admin Only)
            $userRole = $currentUser->role?->name ?? 'user';
            if (!in_array($userRole, ['admin', 'super admin'])) {
                return ApiResponse::error('Unauthorized', 'Access restricted to admins', 403);
            }

            // 2️⃣ Fetch Soft-Deleted Members Query
            $query = Member::withTrashed()
                ->where(function ($q) {
                    $q->whereNotNull('deleted_at') // soft deleted
                        ->orWhere('is_deleted', 1);  // manual flag delete
                });
            
            $this->applyDuplicateFilter($query, true);

            $query->with([
                    'membership',
                    'profile' => function ($q) {
                        $q->with(['user', 'familyDetail'])
                            ->withCount([
                                'followers',
                                'following',
                                'interestsSent',
                                'interestsReceived',
                                'blockedProfiles',
                                'shortlistedProfiles',
                            ]);
                    }
                ]);

            // Apply Filters
            if ($request->has('filters')) {
                $filters = $request->input('filters'); // Expected to be an array

                if (!empty($filters['member_no'])) {
                    $query->where('member_no', 'like', '%' . $filters['member_no'] . '%');
                }

                if (!empty($filters['phone'])) {
                    $phone = $filters['phone'];
                    $query->whereHas('profile.user', function ($q) use ($phone) {
                        $q->where('phone', 'like', '%' . $phone . '%');
                    });
                }

                if (!empty($filters['user_name'])) {
                    $name = $filters['user_name'];
                    $query->whereHas('profile.user', function ($q) use ($name) {
                        $q->where('name', 'like', '%' . $name . '%');
                    });
                }
            }

            $query->latest('deleted_at');

            // 3️⃣ Pagination Logic
            if ($request->has('page') || $request->has('per_page')) {
                $perPage = $request->input('per_page', 10);
                $paginator = $query->paginate($perPage);
                $deletedMembers = $paginator->items();
                $total = $paginator->total();
            } else {
                $deletedMembers = $query->get();
                $total = $deletedMembers->count();
            }

            // 4️⃣ Map Data
            $mappedData = collect($deletedMembers)->map(fn($m) => [
                'id' => $m->id,
                'profile_id' => $m->profile->id ?? null,
                'name' => $m->profile->user->name ?? null,
                'profile_gender' => $m->profile->gender ?? null,
                'phone' => $m->profile->user->phone ?? null,
                'is_reported' => $m->profile->is_reported ?? false,
                'membership_slug' => $m->membership->name ?? null,
                'profile_marital_status' => $m->profile->marital_status ?? null,
                'profiles_used' => $m->profiles_view_remaining ?? 0,
                'member_no' => $m->member_no ?? null,
                'member_created_date' => $m->created_at->format('d-m-Y H:i:s'),
                'soveran_details' => $m->profile->familyDetail->soveran_details ?? null,
                'profile_photo' => $m->profile?->profile_photo
                    ? $m->profile->profile_photo
                    : (strtolower($m->profile?->gender) === 'female'
                        ? 'storage/default_image/default_female.jpg'
                        : 'storage/default_image/default_male.jpg'),
                'created_at' => $m->created_at->format('d-m-y'),
                'status' => $m->status,

                // ✅ COUNTS
                'followers_count' => $m->profile->followers_count ?? 0,
                'following_count' => $m->profile->following_count ?? 0,
                'interest_sent_count' => $m->profile->interests_sent_count ?? 0,
                'interest_received_count' => $m->profile->interests_received_count ?? 0,
                'blocked_count' => $m->profile->blocked_profiles_count ?? 0,
                'shortlist_count' => $m->profile->shortlisted_profiles_count ?? 0,
            ]);

            // Return custom structure to include total for pagination
            return ApiResponse::success('Deleted members fetched successfully', [
                'records' => $mappedData,
                'total' => $total
            ]);
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to fetch deleted members', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {

            $this->authorize('delete', Member::class);

            $user = Auth::user();

            // 1️⃣ Find Member (Active Only)
            $member = Member::find($id);

            if (!$member) {
                return ApiResponse::error('Member not found', null, 404);
            }

            // // 2️⃣ Authorization
            // // $this->authorize('delete', $member); 
            // // Ensure only admin can delete or owner
            // if ($user->role?->name !== 'admin' && $user->role?->name !== 'super admin') {
            //      // Check if it's their own account
            //      if ($member->profile->user_id !== $user->id) {
            //          return ApiResponse::error('Unauthorized', 'You cannot delete this member', 403);
            //      }
            // }

            // 3️⃣ Audit Log BEFORE Delete
            DeletedMember::create([
                'member_id' => $member->id,
                'deleted_by' => $user->id,
                'deleted_at' => now(), // Explicitly setting this matches our log table
            ]);

            // 4️⃣ Soft Delete
            $member->delete(); // This updates `deleted_at` in members table

            // 5️⃣ Optional: Update Status
            // $member->update(['status' => 'cancelled']); 
            // Not strictly needed if we rely on deleted_at, but good for clarity if status field exists.

            DB::commit();

            return ApiResponse::success('Member deleted successfully', null);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Member Delete Error: ' . $e->getMessage());
            return ApiResponse::error('Failed to delete member', $e->getMessage(), 500);
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return ApiResponse::error('User not authenticated', null, 401);
            }

            $validator = Validator::make($request->all(), [
                'current_password' => 'required|string',
                'new_password' => 'required|string|min:8',
                'confirm_password' => 'required|string|same:new_password',
            ]);

            if ($validator->fails()) {
                return ApiResponse::error('Failed to change password', $validator->errors()->first(), 422);
            }

            if (!Hash::check($request->current_password, $user->password)) {
                return ApiResponse::error('Current password is incorrect', null, 400);
            }

            $user->password = Hash::make($request->new_password);
            $user->save();

            Log::info('ACTION: Password changed', [
                'user_id' => $user->id,
            ]);

            return ApiResponse::success('Password changed successfully', null);
        } catch (\Throwable $e) {
            Log::error('Failed to change password', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return ApiResponse::error('Failed to change password', $e->getMessage(), 500);
        }
    }

    public function searchReport(Request $request)
    {
        try {
            $query = Member::with(['profile.user', 'membership']);
            
            $this->applyDuplicateFilter($query);

            // 1. Filter by Member Type (Online / Offline)
            if ($request->has('member_type') && in_array($request->member_type, ['online', 'offline'])) {
                $query->whereHas('profile', function ($q) use ($request) {
                    $q->where('registration_mode', $request->member_type);
                });
            }

            // 2. Filter by Date Range
            if ($request->has('date_filter') && $request->date_filter) {
                switch ($request->date_filter) {
                    case 'Today':
                        $query->whereDate('created_at', now()->today());
                        break;
                    case 'Last Week':
                        $query->whereBetween('created_at', [now()->subWeek(), now()]);
                        break;
                    case 'Last Month':
                        $query->whereBetween('created_at', [now()->subMonth(), now()]);
                        break;
                    case 'Last 3 Months':
                        $query->whereBetween('created_at', [now()->subMonths(3), now()]);
                        break;
                    case 'Half Yearly':
                        $query->whereBetween('created_at', [now()->subMonths(6), now()]);
                        break;
                    case 'Yearly':
                        $query->whereBetween('created_at', [now()->subYear(), now()]);
                        break;
                }
            }

            // 3. Custom Date Range (From / To)
            if ($request->has('from_date') && $request->from_date) {
                $query->whereDate('created_at', '>=', $request->from_date);
            }
            if ($request->has('to_date') && $request->to_date) {
                $query->whereDate('created_at', '<=', $request->to_date);
            }

            // 4. Column Filters
            if ($request->filled('member_no')) {
                $query->where('member_no', $request->member_no);
            }
            if ($request->filled('name')) {
                $query->whereHas('profile.user', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->name . '%');
                });
            }
            if ($request->filled('profile_gender')) {
                $query->whereHas('profile', function ($q) use ($request) {
                    $q->where('gender', $request->profile_gender);
                });
            }
            if ($request->filled('membership_slug')) {
                $query->whereHas('membership', function ($q) use ($request) {
                    $q->where('slug', 'like', '%' . $request->membership_slug . '%');
                });
            }
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            // Clone query for counts BEFORE pagination
            $countQuery = clone $query;
            $activeQuery = clone $query;
            $inactiveQuery = clone $query;
            $maleQuery = clone $query;
            $femaleQuery = clone $query;

            // ✅ FIX: Calculate counts using separate queries for performance & correctness
            $counts = [
                'total_members' => $countQuery->count(),
                'male_count' => $maleQuery->whereHas('profile', function ($q) {
                    $q->where('gender', 'male');
                })->count(),
                'female_count' => $femaleQuery->whereHas('profile', function ($q) {
                    $q->where('gender', 'female');
                })->count(),
                'active_members' => $activeQuery->where('status', 'active')->count(),
                'inactive_members' => $inactiveQuery->where('status', '!=', 'active')->count(),
            ];

            // 4. Pagination
            $perPage = $request->get('per_page', 20);
            $page = $request->get('page', 1);

            $paginated = $query->paginate($perPage, ['*'], 'page', $page);

            // Map data for table
            $data = collect($paginated->items())->map(function ($m) {
                return [
                    'id' => $m->id,
                    'name' => $m->profile?->user?->name ?? null,
                    'profile_gender' => $m->profile?->gender ?? null,
                    'profile_photo' => $m->profile?->profile_photo
                        ? $m->profile->profile_photo
                        : (strtolower($m->profile?->gender) === 'female'
                            ? 'storage/default_image/default_female.jpg'
                            : 'storage/default_image/default_male.jpg'),
                    'registration_mode' => $m->profile?->registration_mode ?? null,
                    'membership_slug' => $m->membership?->slug ?? null,
                    'profile_marital_status' => $m->profile?->marital_status ?? null,
                    'member_no' => $m->member_no ?? null,
                    'phone' => $m->profile?->user?->phone ?? $m->profile?->mobile ?? null,
                    'is_reported' => $m->is_reported ?? false,
                    'is_renewed' => $m->isRenewed ?? 0,
                    'profiles_used' => $m->profiles_used ?? 0,
                    'created_at' => optional($m->created_at)->format('Y-m-d'),
                    'status' => $m->status,
                ];
            });

            // Construct paginated response manually to preserve structure
            $paginatedResponse = [
                'current_page' => $paginated->currentPage(),
                'data' => $data,
                'first_page_url' => $paginated->url(1),
                'from' => $paginated->firstItem(),
                'last_page' => $paginated->lastPage(),
                'last_page_url' => $paginated->url($paginated->lastPage()),
                'links' => [], // $paginated->linkCollection()->toArray(), // Simplify for now to avoid version issues
                'next_page_url' => $paginated->nextPageUrl(),
                'path' => $paginated->path(),
                'per_page' => $paginated->perPage(),
                'prev_page_url' => $paginated->previousPageUrl(),
                'to' => $paginated->lastItem(),
                'total' => $paginated->total(),
            ];

            return ApiResponse::success('Search report fetched successfully', [
                'members' => $paginatedResponse,
                'counts' => $counts
            ]);
        } catch (\Throwable $e) {
            return ApiResponse::error('Failed to fetch search report', $e->getMessage(), 500);
        }
    }

    private function applyDuplicateFilter($query, $includeDeleted = false)
    {
        return $query->whereIn('members.id', function ($subquery) use ($includeDeleted) {
            $subquery->selectRaw('MAX(m.id)')
                ->from('members as m')
                ->join('profiles as p', 'm.profile_id', '=', 'p.id')
                ->join('users as u', 'p.user_id', '=', 'u.id');

            if ($includeDeleted) {
                $subquery->whereNotNull('m.deleted_at');
            } else {
                $subquery->whereNull('m.deleted_at');
            }

            $subquery->groupBy('u.phone', 'p.gender');
        });
    }
}