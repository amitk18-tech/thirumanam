<?php

namespace App\Services\Auth;

use App\Http\Responses\ApiResponse;
use Illuminate\Support\Facades\Auth;
use Twilio\Rest\Client;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Str;



class AuthPhoneService
{
    protected $userRepository;
    protected $twilio;
    protected $twilioVerifySid;
    protected $roleRepository;


    public function __construct(UserRepository $userRepository, RoleRepository $roleRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;

        $this->twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
        $this->twilioVerifySid = env('TWILIO_VERIFICATION_SERVICE_SID');
    }

    // Register and Send OTP
    public function register(array $data)
    {


        print_r($data); // Debugging line to check input data

        $roleId = $this->roleRepository->getRoleIdByName('user');
        if (!$roleId) {
            return ApiResponse::error('Default role "user" not found', null, 400);
        }

        $data['role_id'] = $roleId;
        $data['password'] = bcrypt($data['password']);

        $user = $this->userRepository->create($data);
        if (!$user) {
            return ApiResponse::error('User not created', null, 400);
        }

        $otp = $this->sendOtp($user->phone); // Send OTP manually

        return ApiResponse::success('User created successfully. OTP sent to phone.', [
            'otp' => $otp, // ⚠️ Show only in dev
            'phone' => $user->phone,
        ], 200);
    }

    public function sendOtp($phoneNumber)
    {
        // Standardize phone format if needed
        $phoneNumber = ltrim($phoneNumber, '0');

        // Generate OTP
        $otp = rand(1000, 9999);

        // Optional: send via Twilio or SMS gateway here
        // For now, just store in DB
        $user = User::where('phone_number', $phoneNumber)
            ->orWhere('phone_number', '+91' . $phoneNumber)
            ->first();

        if ($user) {
            $user->update([
                'verification_code' => $otp,
                'verification_code_expires_at' => now()->addMinutes(30),
                'otp_attempts' => 0,
            ]);
        }

        return $otp;
    }

    public function verifyOtp(string $phone, string $code)
    {
        // Remove one leading zero if present (safe trim)
        $cleanPhone = $phone;

        // 🔍 Match only clean phone — no +91 needed
        $user = User::where('phone_number', $cleanPhone)->first();

        if (!$user) {
            return ApiResponse::error('User not found', null, 404);
        }

        // 🪵 Log for debug
        logger(json_encode([
            'Stored OTP' => $user->verification_code,
            'Expiry Time' => $user->verification_code_expires_at,
            'Current Time' => now(),
            'User Input OTP' => $code,
        ]));

        // ✅ OTP match check
        if (
            strval($user->verification_code) !== strval($code) ||
            !$user->verification_code_expires_at ||
            now()->greaterThan($user->verification_code_expires_at)
        ) {
            return ApiResponse::error('Invalid or expired OTP', null, 400);
        }

        // ✅ Mark verified
        $user->update([
            'verified' => true,
            'verification_code' => null,
            'verification_code_expires_at' => null,
        ]);

        // 🏢 Tenant creation if not exists
        if (!$user->tenant) {
            $tenantData = [
                'name' => $user->name ?? 'Tenant-' . $user->id,
                'email' => $user->email,
                'phone_number' => $user->phone_number,
                'slug' => Str::slug($user->name ?? 'Tenant-' . $user->id),
                'created_by' => $user->id,
                'status' => 'active',
                'trial_ends_at' => now()->addDays(14),
            ];

            \App\Models\Tenant::create($tenantData);
        }

        // Update user's tenant_id after tenant creation
        $tenant = \App\Models\Tenant::where('created_by', $user->id)->latest()->first();
        if ($tenant) {
            $user->update(['tenant_id' => $tenant->id]);
        }

        return ApiResponse::success('OTP verified and tenant created');
    }


    // Resend OTP
    public function resendOtp(string $phone)
    {
        $user = User::where('phone', $phone)->first();

        if (!$user) {
            return ApiResponse::error('User not found', null, 404);
        }

        $this->sendOtp($phone);

        return ApiResponse::success('OTP resent successfully');
    }

    // Login
    public function login(array $credentials)
    {
        if (!Auth::attempt($credentials)) {
            return ApiResponse::error('Invalid credentials', null, 401);
        }

        $user = Auth::user();

        if (!$user->verified) {
            return ApiResponse::error('Phone not verified. Please verify your phone number.', null, 403);
        }

        $token = $user->createToken('authToken')->plainTextToken;

        return ApiResponse::success('Login successful', [
            'id' => $user->id,
            'username' => $user->username,
            'firstname' => $user->firstname,
            'lastname' => $user->lastname,
            'role_id' => $user->role_id,
            'role_name' => $user->role->name ?? null,
            'verified' => $user->verified,
            'phone' => $user->phone,
            'email' => $user->email,
            'status' => $user->status,
            'profile_picture' => $user->profile_picture,
            'token' => $token,
        ]);
    }

    // Logout
    public function logout()
    {
        $user = Auth::user();

        if (!$user) {
            return ApiResponse::error('User not authenticated', null, 401);
        }

        $user->tokens()->delete();

        return ApiResponse::success('Logout successful');
    }

    // Optional: Get user by phone
    public function findByPhone(string $phone)
    {
        return $this->userRepository->findByPhone($phone);
    }
}