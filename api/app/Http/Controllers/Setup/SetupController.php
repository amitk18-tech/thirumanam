<?php

namespace App\Http\Controllers\Setup;

use Illuminate\Http\Request;
use Bits\Package\Models\Token;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller;
use Bits\Package\Responses\ApiResponse;
use Bits\Package\Services\TwilioService;


class SetupController extends Controller
{

    protected $twilioService;

    public function __construct(TwilioService $twilioService)
    {
        $this->twilioService = $twilioService;
    }

    /**
     * Step 1: Request OTP to phone
     */
    public function requestOtp(Request $request)
    {

        try {
            //$request->validate(['phone' => 'required|string|size:10']);

            // Check if user already exists
            if (User::where('phone', $request->phone)->exists()) {
                return ApiResponse::error('Login failed', 'Phone already registered.');
            }

            // Generate OTP
            $otp = rand(1000, 9999);

            // Store in tokens table
            Token::create([
                'phone' => $request->phone,
                'token' => $otp,
                'type' => 'otp',
                'expires_at' => now()->addMinutes(5),
            ]);

            // $message = $this->twilioService->sendSmsOtp($request->phone, $otp);

            return ApiResponse::success('OTP sent', ['phone' => $request->phone, 'otp' => $otp]);
        } catch (\Throwable $e) {
            return ApiResponse::error('Error fetching with category', $e->getMessage());
        }
    }

    /**
     * Step 2: Verify OTP and generate temp setup token
     */
    public function verifyOtp(Request $request)
    {

        try {
            // $request->validate([
            //     'phone' => 'required|string',
            //     'otp' => 'required|string'
            // ]);

            $otpToken = Token::where('phone', $request->phone)
                ->where('token', $request->otp)
                ->where('type', 'otp')
                ->where('is_used', false)
                ->where('expires_at', '>', now())
                ->latest()
                ->first();

            if (!$otpToken) {
                return ApiResponse::error('Verification failed', 'Invalid or expired OTP.');
            }

            // Mark OTP used
            $otpToken->is_used = true;
            $otpToken->save();

            // Generate temp setup token
            $setupToken = Str::uuid();

            Token::create([
                'phone' => $request->phone,
                'token' => $setupToken,
                'type' => 'setup',
                'expires_at' => now()->addMinutes(15),
            ]);

            return ApiResponse::success('OTP verified', ['setup_token' => $setupToken, 'phone' => $request->phone]);
        } catch (\Throwable $e) {
            return ApiResponse::error('Verification failed', $e->getMessage());
        }
    }

    /**
     * Step 3: Complete Setup with account and tenant info
     */
    public function completeSetup(Request $request)
    {
        try {
         

            $token = Token::where('token', $request->setup_token)
                ->where('type', 'setup')
                ->where('is_used', false)
                ->where('expires_at', '>', now())
                ->first();

            if (!$token || !$token->phone) {
                return ApiResponse::error('Invalid or expired setup token', 422);
            }


            // Assign default user role (assumed 'user' exists)
            $userRole = Role::where('name', 'user')->firstOrFail();

            // Create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $token->phone,
                'password' => Hash::make($request->password),
                'role_id' => $userRole->id,
                'is_active' => true,
                'last_login_at' => now(),
            ]);

            $token->is_used = true;
            $token->save();
            return ApiResponse::success('Registration completed successfully', [
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'role' => $userRole->name,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,

            ]);
        } catch (\Throwable $e) {
            return ApiResponse::error('Error completing setup', $e->getMessage());
        }
    }
}