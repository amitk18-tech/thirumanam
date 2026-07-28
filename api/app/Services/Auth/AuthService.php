<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Models\Member;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Bits\Package\Services\BaseAuthService;

class AuthService extends BaseAuthService
{
    protected string $loginField = 'phone';

    protected function getUserModel(): string
    {
        return User::class;
    }

    protected function detectLoginField(string $loginValue): string
    {
        // email detection
        if (filter_var($loginValue, FILTER_VALIDATE_EMAIL)) {
            return 'email';
        }

        // phone detection (10–15 digits)
        if (preg_match('/^[0-9]{10,15}$/', $loginValue)) {
            return 'phone';
        }

        // fallback
        return 'username';
    }

    protected function loadRelationships($user): void
    {
        $user->load([
            'profile',
            'role'
        ]);
    }

    protected function formatUserData($user, array $cleanedUser): array
    {
        // Example: Add profile picture URL if profile exists
        if ($user->profile) {
            $cleanedUser['profile_picture_url'] = $user->profile->picture_url ?? null;
            $cleanedUser['gender'] = $user->profile->gender ?? null;
        }
        return $cleanedUser;
    }


    /**
     * Override login to handle multiple profiles (genders) for the same identifier.
     */
    public function login(Request $request, string $loginField = 'phone')
    {

        //1. login - success or failure
        //2. get profiles for the user.
        //3. if no profile found, return Empty

        $loginValue = $request->get('login_id') ?? $request->get('login_value') ?? $request->get($this->loginField);

        if (!$loginValue) {
            return [
                'success' => false,
                'message' => 'Login identifier is required.',
            ];
        }

        $field = $this->detectLoginField($loginValue);
        $users = User::where($field, $loginValue)->with('profile')->get();

        if ($users->isEmpty()) {
            return [
                'success' => false,
                'message' => 'Invalid credentials',
            ];
        }

        // Collect existing genders
        $existingGenders = [];
        $userWithoutProfile = null;

        foreach ($users as $u) {
            $gender = $u->profile->gender ?? null;
            if ($gender) {
                $existingGenders[] = $gender;
            } else {
                $userWithoutProfile = $u;
            }
        }

        $user = null;

        // If specific gender is requested
        if ($request->has('gender')) {
            $requestedGender = strtolower($request->gender);

            // 1. Check if profile already exists for this gender
            $user = $users->first(function ($u) use ($requestedGender) {
                return strtolower($u->profile->gender ?? '') === $requestedGender;
            });

            // 2. If not found, look for a base user without a profile to "adopt" this gender
            if (!$user && $userWithoutProfile) {
                $user = $userWithoutProfile;
            }

            // 3. Fallback: If no user found and no base user, return error or handle creation (depending on project rules)
            // For now, we follow the "resolve or create" instruction.
            if (!$user) {
                return [
                    'success' => false,
                    'message' => 'Profile not found for selected gender and no available base account.',
                ];
            }
        } else {
            // DECISION LOGIC (Backend source of truth)
            $count = count($existingGenders);

            if ($count === 0) {
                // CASE: No profiles -> Frontend shows "Select gender to create"
                return [
                    'success' => true,
                    'existing_genders' => [],
                    'message' => 'No profiles found.',
                ];
            } elseif ($count > 1) {
                // CASE: Multiple profiles -> Check password first to identify profile
                $matchingUsers = $users->filter(function ($u) use ($request) {
                    if (strlen($u->password) === 40) {
                        return sha1($request->password ?? '') === $u->password;
                    }
                    return Hash::check($request->password ?? '', $u->password);
                });

                if ($matchingUsers->isEmpty()) {
                    return [
                        'success' => false,
                        'message' => 'Invalid credentials',
                    ];
                }

                if ($matchingUsers->count() === 1) {
                    // Password uniquely identifies the profile → auto-login
                    $user = $matchingUsers->first();
                } else {
                    // Same password matches both profiles → ask user to choose
                    $profiles = $matchingUsers->map(function ($u) {
                        return [
                            'id' => $u->id,
                            'gender' => $u->profile->gender ?? null,
                            'name' => $u->name ?? null,
                            'member_no' => $u->profile->member_no ?? null,
                        ];
                    })->values()->toArray();

                    return [
                        'success' => true,
                        'login_status' => 'multiple_profiles',
                        'profiles' => $profiles,
                        'message' => 'Multiple profiles found. Please select one.',
                    ];
                }
            }

            // CASE: Exactly one profile -> Auto-login as that user
            if (!isset($user)) {
                $user = $users->first(function ($u) {
                    return isset($u->profile->gender);
                });
            }
        }

        // 1️⃣ OLD SHA1 password upgrade (if applicable)
        if (strlen($user->password) === 40) {
            if (sha1($request->password) !== $user->password) {
                return [
                    'success' => false,
                    'message' => 'Invalid credentials',
                ];
            }
            $user->password = Hash::make($request->password);
            $user->save();
        }

        // 2️⃣ Verify password (bcrypt)
        if (!Hash::check($request->password, $user->password)) {
            return [
                'success' => false,
                'message' => 'Invalid credentials',
            ];
        }

        $roleName = strtolower($user->role?->name ?? 'user');
        if (!in_array($roleName, ['admin', 'super admin']) && $user->profile?->id) {
            $member = Member::where('profile_id', $user->profile->id)
                ->latest('id')
                ->first();

            if ($member && (bool) $member->is_deactivated) {
                return [
                    'success' => false,
                    'message' => 'Your account is deactivated. Please contact admin to reactivate.',
                    'error_code' => 'ACCOUNT_DEACTIVATED',
                ];
            }
        }

        // 3️⃣ Generate Token and Format User Data
        $token = $user->createToken('Personal Access Token')->plainTextToken;
        $cleanedUser = $user->makeHidden(['password', 'remember_token'])->toArray();

        // Load relationships (optional hook)
        $this->loadRelationships($user);

        $role = $user->role;
        $cleanedUser['role_name'] = $role->name ?? null;
        $cleanedUser['role_slug'] = $role->slug ?? null;
        $cleanedUser['permissions'] = method_exists($user, 'getPermissions') ? $user->getPermissions() : [];
        $cleanedUser['existing_genders'] = $existingGenders; // Include for frontend if needed

        // Apply app-specific formatting
        $cleanedUser = $this->formatUserData($user, $cleanedUser);

        return [
            'success' => true,
            'token' => $token,
            'user' => $cleanedUser,
        ];
    }

    public function adminLogin(Request $request, string $loginField = 'phone')
    {
        // 1️⃣ Find user manually first
        $user = User::where($loginField, $request->$loginField)->first();

        if (!$user) {
            return [
                'success' => false,
                'message' => 'Invalid credentials'
            ];
        }

        // 2️⃣ OLD SHA1 password (CodeIgniter)
        if (strlen($user->password) === 40) {

            if (sha1($request->password) !== $user->password) {
                return [
                    'success' => false,
                    'message' => 'Invalid credentials'
                ];
            }

            // ✅ Upgrade to bcrypt
            $user->password = Hash::make($request->password);
            $user->save();
        }

        // 3️⃣ Continue NORMAL Laravel login flow
        // (password check + token handled by BaseAuthService)
        return parent::login($request, $loginField);
    }
}