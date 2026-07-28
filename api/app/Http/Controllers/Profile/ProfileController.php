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

use Illuminate\Http\Request;
use Bits\Package\Responses\ApiResponse;
use Illuminate\Support\Facades\DB;

class ProfileController extends BaseController
{
    protected BaseService $membershipService;
    protected BaseService $membersService;

    public function __construct()
    {
        $this->policyModel = Profile::class;

        $this->middleware(function ($request, $next) {
            $authUser = Auth::user();

            Log::info('PROFILE: Authenticated User', [
                'user_id' => $authUser?->id,
                'role' => $authUser?->role, // string enum: 'user' or 'admin'
                'permissions' => $authUser?->permissions, // now works via accessor
            ]);

            // 🚨 No tenant_id in profiles → pass null
            $this->service = new BaseService(
                new BaseRepository(new Profile(), null),
            );

            $this->membershipService = new BaseService(
                new BaseRepository(new Membership(), null),
            );

            $this->membersService = new BaseService(
                new BaseRepository(new Member(), null),
            );

            return $next($request);
        });


        // Validation rules for creating a profile
        $this->storeRules = [
            'user_id' => 'required|exists:users,id',
            'introduction' => 'nullable|string',
            'gender' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'age' => 'nullable|integer|min:0',
            'marital_status' => 'nullable|in:divorced,separated,widowed,never_married',
            'number_of_children' => 'nullable|integer|min:0',
            'children_living_place' => 'nullable|in:living_with_me,not_living_with_me',
            'registration_mode' => 'nullable|in:offline,online',
            'membership_type' => 'nullable|in:default,essential,classic,premium',
            'day_of_birth' => 'nullable|string|max:255',
            'birth_time' => 'nullable|string|max:255',
            'paksha' => 'nullable|string|max:255',
            'star' => 'nullable|string|max:255',
            'rasi' => 'nullable|string|max:255',
            'padam' => 'nullable|string|max:255',
            'nakshatra' => 'nullable|string|max:255',
            'charan' => 'nullable|string|max:255',
            'lakknam' => 'nullable|string|max:255',
            'horoscope_matching' => 'nullable|string|max:255',
            'dosham' => 'nullable|string|max:255',
            'tithi' => 'nullable|string|max:255',
            'ganam' => 'nullable|string|max:255',
            'nadi' => 'nullable|string|max:255',
            'directional_balance' => 'nullable|string|max:255',
            'type_of_dosham' => 'nullable|string|max:255',
            'other_dosham' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'year' => 'nullable|string',
            'month' => 'nullable|string',
            'day' => 'nullable|string',
            'birth_place' => 'nullable|string|max:255',
            'birth_country' => 'nullable|string|max:255',
            'birth_state' => 'nullable|string|max:255',
            'birth_city' => 'nullable|string|max:255',
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
            'height' => 'nullable|integer|min:0',
            'weight' => 'nullable|integer|min:0',
            'complexion' => 'nullable|string|max:255',
            'body_type' => 'nullable|string|max:255',
            'body_art' => 'nullable|string|max:255',
            'blood_group' => 'nullable|string|max:10',
            'physical_status' => 'nullable|string|max:255',
            'eye_color' => 'nullable|string|max:50',
            'hair_color' => 'nullable|string|max:50',
            'education' => 'nullable|string|max:255',
            'occupation' => 'nullable|string|max:255',
            'income' => 'nullable|string|max:255',
            'work_location' => 'nullable|string|max:255',
            'study_details' => 'nullable|string',
            'career_profile' => 'nullable|string',
            'earnings' => 'nullable|in:year,month',
            'income_amount' => 'nullable|numeric|min:0',
            'profile_photo' => 'nullable|image',
            'horoscope_file' => 'nullable|file',

        ];


        // Validation rules for updating a profile
        $this->updateRules = [
            'user_id' => 'sometimes|exists:users,id',
            'introduction' => 'nullable|string',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'gender' => 'sometimes|in:male,female',
            'dob' => 'nullable|date',
            'age' => 'nullable|integer|min:0',
            'marital_status' => 'sometimes|in:divorced,separated,widowed,never_married',
            'number_of_children' => 'nullable|integer|min:0',
            'children_living_place' => 'nullable|in:living_with_me,not_living_with_me',
            'profile_created_for' => 'nullable|string|max:255',
            'registration_mode' => 'nullable|in:offline,online',
            'membership_type' => 'sometimes|in:default,essential,classic,premium',
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
            'type_of_dosham' => 'nullable|string|max:255',
            'other_dosham' => 'nullable|string|max:255',
            'paksha' => 'nullable|string|max:255',
            'tithi' => 'nullable|string|max:255',
            'directional_balance' => 'nullable|string|max:255',
            'day_of_birth' => 'nullable|string|max:255',
            'birth_time' => 'nullable|string|max:255',
            'birth_place' => 'nullable|string|max:255',
            'birth_country' => 'nullable|string|max:255',
            'birth_state' => 'nullable|string|max:255',
            'birth_city' => 'nullable|string|max:255',
            'lakknam' => 'nullable|string|max:255',
            'horoscope_matching' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'year' => 'nullable|string',
            'month' => 'nullable|string',
            'day' => 'nullable|string',

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
        ];
    }

    public function index(Request $request)
    {
        try {
            Log::info('ACTION: Fetching profiles', [
                'user_id' => Auth::id(),
                'filters' => $request->get('filters', []),
                'joins' => $request->get('joins', []),
                'with' => $request->get('with', [
                    'user',
                    'user.role',
                    'familyDetail',
                    'partnerPreference',
                    'photos',
                    'member',
                    'horoscopeBoxes',
                ])
            ]);

            $this->authorize('viewAny', $this->policyModel);

            $filters = [];

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
                    'user',
                    'familyDetail',
                    'partnerPreference',
                    'photos',
                    'member',
                    'horoscopeBoxes'
                ])
            );

            // 🔥 FLATTEN RESULT LIKE MEMBER
            $data = $profiles->map(function ($p) {
                return [
                    'id' => $p->id,
                    'first_name' => $p->first_name,
                    'last_name' => $p->last_name,
                    'email' => $p->email,
                    'phone' => $p->phone,
                    'gender' => $p->gender,
                    'dob' => $p->date_of_birth,
                    'age' => $p->age,
                    'height' => $p->height,
                    'weight' => $p->weight,
                    'marital_status' => $p->marital_status,
                    'religion' => $p->religion,
                    'caste' => $p->caste,
                    'subcaste' => $p->subcaste,
                    'education' => $p->education,
                    'occupation' => $p->occupation,
                    'income' => $p->income,
                    'country' => $p->country,
                    'state' => $p->state,
                    'city' => $p->city,
                    'address' => $p->address,
                    'bio' => $p->bio,


                    // MEMBER

                    'profile_id' => $p->id,
                    'membership_id' => $p->member->membership_id ?? null,
                    'membership_name' => $p->member->membership->name ?? null,
                    'membership_start_date' => $p->member->start_date ?? null,
                    'membership_end_date' => $p->member->end_date ?? null,
                    'membership_status' => $p->member->status ?? null,



                    // USER
                    'user_id' => $p->user->id ?? null,
                    'user_name' => $p->user->name ?? null,
                    'user_email' => $p->user->email ?? null,
                    'user_role' => $p->user->role->name ?? null,
                    'created_at' => $p->user->created_at?->format('Y-m-d H:i:s'),
                    'updated_at' => $p->user->updated_at?->format('Y-m-d H:i:s'),



                    // MEMBER (same like your member flatten)

                    'membership_start' => $p->member->start_date ?? null,
                    'membership_end' => $p->member->end_date ?? null,


                    'membership_slug' => $p->member->membership->slug ?? null,
                    'membership_price' => $p->member->membership->price ?? null,
                    'membership_duration_days' => $p->member->membership->duration_days ?? null,
                    'membership_description' => $p->member->membership->description ?? null,

                    // Usage fields 
                    'sent_interest_remaining' => $p->member->sent_interest_remaining ?? null,
                    'profiles_view_remaining' => $p->member->profiles_view_remaining ?? null,
                    'messages_sent_remaining' => $p->member->messages_sent_remaining ?? null,



                ];
            });

            return ApiResponse::success('Fetched successfully', $data);
        } catch (\Throwable $e) {
            return ApiResponse::error('Failed to fetch', $e->getMessage(), 500);
        }
    }




    public function show($id, Request $request)
    {
        try {
            // Load the actual Profile instance
            $profile = Profile::with($request->get('with', default: [
                'user',
                'user.role',
                'familyDetail',
                'partnerPreference',
                'photos',
                'member',
                'horoscopeBoxes',
            ]))->findOrFail($id);

            // Authorize with the model instance
            $this->authorize('view', $profile);

            Log::info('ACTION: Viewing record', [
                'user_id' => Auth::id(),
                'profile_id' => $id,
            ]);

            return ApiResponse::success('Record found', $profile);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return ApiResponse::error('Unauthorized', $e->getMessage(), 403);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return ApiResponse::error('Record not found', $e->getMessage(), 404);
        } catch (\Throwable $e) {
            return ApiResponse::error('Failed to retrieve record', $e->getMessage(), 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {

            $profile = Profile::findOrFail($id);


            // Validation
            $validatedData = $request->validate($this->updateRules);

            Log::info('ACTION: Updating record', [
                'user_id' => Auth::id(),
                'profile_id' => $id,
                'validated_data' => $validatedData,
            ]);

            $extraData = [];

            /*
            |---------------------------------------------------------------------------
            | Upload: Profile Photo
            |---------------------------------------------------------------------------
            */
            if (isset($validatedData['profile_photo']) && $validatedData['profile_photo'] instanceof \Illuminate\Http\UploadedFile) {
                $timestamp = now()->format('Y_m_d_H_i_s');
                $extension = $validatedData['profile_photo']->getClientOriginalExtension();
                $random = rand(10000, 99999);
                $fileName = "profile_{$timestamp}_{$random}.{$extension}";
                $path = $validatedData['profile_photo']->storeAs("profiles/" . now()->format('Y') . "/" . now()->format('m'), $fileName, 'public');
                $extraData['profile_photo'] = "storage/{$path}";
                $extraData['profile_photo_url'] = url("storage/{$path}");
            }

            /*
            |---------------------------------------------------------------------------
            | Upload: Horoscope File
            |---------------------------------------------------------------------------
            */
            if (isset($validatedData['horoscope_file']) && $validatedData['horoscope_file'] instanceof \Illuminate\Http\UploadedFile) {
                $timestamp = now()->format('Y_m_d_H_i_s');
                $extension = $validatedData['horoscope_file']->getClientOriginalExtension();
                $random = rand(10000, 99999);
                $fileName = "horoscope_{$timestamp}_{$random}.{$extension}";
                $path = $validatedData['horoscope_file']->storeAs("horoscope_files/" . now()->format('Y') . "/" . now()->format('m'), $fileName, 'public');
                $extraData['horoscope_file'] = "storage/{$path}";
                $extraData['horoscope_file_url'] = url("storage/{$path}");
            }

            // Merge uploaded file data
            $validatedData = array_merge($validatedData, $extraData);

            // Update the profile
            $updatedProfile = $this->service->update($profile->id, $validatedData);

            return ApiResponse::success('Profile updated successfully', $updatedProfile);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return ApiResponse::error('Unauthorized', $e->getMessage(), 403);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return ApiResponse::error('Profile not found', $e->getMessage(), 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return ApiResponse::error('Validation failed', $e->errors(), 422);
        } catch (\Throwable $e) {
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
                'photos',
                'member',
                'member.membership',
                'horoscopeBoxes',
            ]))
                ->withCount(['followers', 'following'])
                ->where('user_id', $userId)->firstOrFail();

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
            // Validation
            $validatedData = $request->validate($this->storeRules);

            // 🔥 ALWAYS USE LOGGED-IN USER
            $validatedData['user_id'] = Auth::id();

            Log::info('ACTION: Creating profile', [
                'auth_user_id' => Auth::id(),
                'validated_data' => $validatedData,
            ]);

            $extraData = [];

            // Helper for uploads
            $uploadFile = function ($file, $folder, $prefix) {
                $timestamp = now()->format('Y_m_d_H_i_s');
                $extension = $file->getClientOriginalExtension();
                $random = rand(10000, 99999);
                $fileName = "{$prefix}_{$timestamp}_{$random}.{$extension}";
                $path = $file->storeAs("{$folder}/" . now()->format('Y') . "/" . now()->format('m'), $fileName, 'public');

                return [
                    "{$prefix}" => "storage/{$path}",
                    "{$prefix}_url" => url("storage/{$path}")
                ];
            };

            // Upload profile photo
            if (isset($validatedData['profile_photo']) && $validatedData['profile_photo'] instanceof \Illuminate\Http\UploadedFile) {
                $extraData = array_merge($extraData, $uploadFile($validatedData['profile_photo'], 'profiles', 'profile_photo'));
            }

            // Upload horoscope file
            if (isset($validatedData['horoscope_file']) && $validatedData['horoscope_file'] instanceof \Illuminate\Http\UploadedFile) {
                $extraData = array_merge($extraData, $uploadFile($validatedData['horoscope_file'], 'horoscope_files', 'horoscope_file'));
            }

            $validatedData = array_merge($validatedData, $extraData);

            // 🔥 TRANSACTION START
            $result = DB::transaction(function () use ($validatedData) {

                // 1️⃣ CREATE PROFILE
                $profile = $this->service->create($validatedData);

                // 2️⃣ MARK USER PROFILE COMPLETE
                \App\Models\User::where('id', Auth::id())
                    ->update(['is_profile_complete' => 1]);

                // 3️⃣ CREATE DEFAULT MEMBER
                $membershipDefaults = [
                    'sent_interest_allowed' => 0,
                    'messages_sent_allowed' => 0,
                    'profiles_view_allowed' => 0,
                ];

                $memberData = [
                    'profile_id' => $profile->id,
                    'membership_id' => 1,
                    'start_date' => now()->toDateString(),
                    'end_date' => now()->addMonths(6)->toDateString(),
                    'sent_interest_allowed' => $membershipDefaults['sent_interest_allowed'],
                    'messages_sent_allowed' => $membershipDefaults['messages_sent_allowed'],
                    'profiles_view_allowed' => $membershipDefaults['profiles_view_allowed'],
                    'send_reminder' => false,
                    'auto_renewal' => false,
                    'active' => true,
                    'is_closed' => 'no',
                    'status' => 'active',
                    'member_no' => 'Temporary',
                ];

                $member = $this->membersService->create($memberData);

                return [
                    'profile' => $profile,
                    'member' => $member,
                    'user' => \App\Models\User::find(Auth::id()) // updated user
                ];
            });

            return ApiResponse::success('Profile created successfully', $result);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return ApiResponse::error('Validation failed', $e->errors(), 422);
        } catch (\Throwable $e) {
            Log::error('Failed to create profile', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return ApiResponse::error('Failed to create profile', $e->getMessage(), 500);
        }
    }


    // Admin Dashboard use

    // approveProfile

    public function approveProfile($id, Request $request)
    {
        try {
            // Load the actual Profile instance
            $profile = Profile::findOrFail($id);

            // Authorize with the model instance
            $this->authorize('approve', $profile);


            // Update the profile status to 'approved'
            $profile->profile_status = 'approved';
            $profile->is_verified = true; // Assuming admin approval means verified
            $profile->verified_by_admin = true;
            $profile->blocked_by_admin = false;
            $profile->rejected_by_admin = false;
            $profile->rejection_reason = null;

            $profile->save();

            $profileVerificationLog = ProfileVerificationLog::create([
                'profile_id' => $profile->id,
                'admin_id' => Auth::id(),
                'action' => 'verify',
                'reason' => $request->input('reason', 'Approved by admin'),
            ]);

            return ApiResponse::success('Profile approved successfully', [
                'profile' => $profile,
                'verification_log' => $profileVerificationLog,
            ]);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return ApiResponse::error('Unauthorized', $e->getMessage(), 403);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return ApiResponse::error('Profile not found', $e->getMessage(), 404);
        } catch (\Throwable $e) {
            Log::error('Failed to approve profile', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return ApiResponse::error('Failed to approve profile', $e->getMessage(), 500);
        }
    }

    // Block profile

    public function blockProfile($id, Request $request)
    {
        try {
            // Load the actual Profile instance
            $profile = Profile::findOrFail($id);

            // Authorize with the model instance
            $this->authorize('block', $profile);

            Log::info('ACTION: Blocking profile', [
                'admin_user_id' => Auth::id(),
                'profile_id' => $id,
            ]);

            // Update the profile status to 'blocked'
            $profile->profile_status = 'blocked';
            $profile->is_verified = false;
            $profile->verified_by_admin = false;
            $profile->blocked_by_admin = true;
            $profile->rejected_by_admin = false;
            $profile->rejection_reason = $request->input('reason', 'Blocked by admin');
            $profile->save();

            $profileVerificationLog = ProfileVerificationLog::create([
                'profile_id' => $profile->id,
                'admin_id' => Auth::id(),
                'action' => 'block',
                'reason' => $request->input('reason', 'Blocked by admin'),
            ]);

            return ApiResponse::success('Profile blocked successfully', [
                'profile' => $profile,
                'verification_log' => $profileVerificationLog,
            ]);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return ApiResponse::error('Unauthorized', $e->getMessage(), 403);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return ApiResponse::error('Profile not found', $e->getMessage(), 404);
        } catch (\Throwable $e) {
            Log::error('Failed to block profile', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return ApiResponse::error('Failed to block profile', $e->getMessage(), 500);
        }
    }


    // Reject profile

    public function rejectProfile($id, Request $request)
    {
        try {
            // Load the actual Profile instance
            $profile = Profile::findOrFail($id);

            // Authorize with the model instance
            $this->authorize('reject', $profile);

            Log::info('ACTION: Rejecting profile', [
                'admin_user_id' => Auth::id(),
                'profile_id' => $id,
            ]);

            // Update the profile status to 'rejected'
            $profile->profile_status = 'rejected';
            $profile->is_verified = false;
            $profile->verified_by_admin = false;
            $profile->blocked_by_admin = false;
            $profile->rejected_by_admin = true;
            $profile->rejection_reason = $request->input('reason', 'Rejected by admin');
            $profile->save();

            $profileVerificationLog = ProfileVerificationLog::create([
                'profile_id' => $profile->id,
                'admin_id' => Auth::id(),
                'action' => 'reject',
                'reason' => $request->input('reason', 'Rejected by admin'),
            ]);

            return ApiResponse::success('Profile rejected successfully', [
                'profile' => $profile,
                'verification_log' => $profileVerificationLog,
            ]);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return ApiResponse::error('Unauthorized', $e->getMessage(), 403);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return ApiResponse::error('Profile not found', $e->getMessage(), 404);
        } catch (\Throwable $e) {
            Log::error('Failed to reject profile', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return ApiResponse::error('Failed to reject profile', $e->getMessage(), 500);
        }
    }


    public function list($filters = [], $joins = [], $with = [])
    {
        $query = Member::query();

        // Apply filters if any
        if (isset($filters['registration_mode'])) {
            $query->where('registration_mode', $filters['registration_mode']);
        }

        if (array_key_exists('profile_photo', $filters)) {
            $query->whereNull('profile_photo');
        }

        // If joins needed
        $query->join('users', 'users.id', '=', 'members.user_id')
            ->leftJoin('memberships', 'memberships.id', '=', 'members.membership_id');

        // Select only required columns
        $query->select([
            'members.id AS member_id',
            'users.name AS user_name',
            'memberships.name AS membership_name',
            'users.mobile',
            'users.created_at AS user_created_at',
            'members.status',
        ]);

        return $query->get();
    }

    public function getProfileByUserId($userId, Request $request)
    {
        try {
            // Fetch the profile by user ID
            $profile = Profile::with($request->get('with', [
                'user',
                'user.role',
                'familyDetail',
                'partnerPreference',
                'photos',
                'activeMember',
                'activeMember.membership',
                'horoscopeBoxes',
            ]))->where('user_id', $userId)->firstOrFail();



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
}