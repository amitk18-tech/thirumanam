<?php

namespace App\Http\Controllers\Sms;


use Illuminate\Http\Request;
use Bits\Package\Services\SmsGatewayHubService;
use Illuminate\Routing\Controller;
use App\Models\Otp;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Bits\Package\Responses\ApiResponse;
use Bits\Package\Models\Token;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Role;

class SmsGatewayHubController extends Controller
{
    public function send(Request $request, SmsGatewayHubService $sms)
    {
        $request->validate([
            'mobile' => 'required|digits:10',
            'type' => 'required|in:otp,first_time_login,forgot_password',
        ]);

        $raw = $request->mobile;

        // Normalized formats
        $mobile = '91' . $raw;
        $mobileWithPlus = '+91' . $raw;

        $type = $request->type;

        $existingGenders = [];

        if ($type === 'first_time_login') {

            // ✅ SAFE USER LOOKUP (handles all formats)
            $users = User::where(function ($query) use ($raw, $mobile, $mobileWithPlus) {
                $query->where('phone', $raw)
                    ->orWhere('phone', $mobile)
                    ->orWhere('phone', $mobileWithPlus);
            })->pluck('id');

            if ($users->isNotEmpty()) {

                // ✅ CRITICAL FIX → force array
                $userIds = $users->toArray();

                $existingGenders = \App\Models\Profile::whereIn('user_id', $userIds)
                    ->pluck('gender')
                    ->unique()
                    ->values()
                    ->toArray();

                // 🚫 Block if both genders already exist
                if (in_array('male', $existingGenders) && in_array('female', $existingGenders)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Male and Female profiles already exist for this mobile number',
                        'existing_genders' => $existingGenders
                    ], 422);
                }
            }
        }

        /**
         * 🔁 Resend limit (60 sec)
         */
        $lastOtp = \App\Models\Otp::where('mobile', $mobile)
            ->where('type', $type)
            ->latest()
            ->first();

        if ($lastOtp && $lastOtp->created_at->diffInSeconds(now()) < 60) {
            return response()->json([
                'success' => false,
                'message' => 'Please wait before requesting new OTP'
            ], 429);
        }

        /**
         * ❌ Invalidate old OTPs
         */
        \App\Models\Otp::where('mobile', $mobile)
            ->where('type', $type)
            ->where('is_used', false)
            ->update(['is_used' => true]);

        /**
         * 🔐 Generate OTP
         */
        $otp = random_int(100000, 999999);

        /**
         * 💾 Store OTP
         */
        \App\Models\Otp::create([
            'mobile' => $mobile,
            'otp_hash' => Hash::make($otp),
            'type' => $type,
            'expires_at' => now()->addMinutes(5),
        ]);

        /**
         * 📩 SMS content
         */
        if ($type === 'otp') {
            $templateId = config('sms.templates.otp');
            $text = "Use OTP {$otp} to confirm your mobile number.";
        } else {
            $templateId = "1307161908870862373";
            $text = "Kindly don’t share the OTP to anyone. Sharing this gives them full access to your account. Your confidential OTP for first time Login is : {$otp} -SSANPM";
        }

        /**
         * 📡 Send SMS via Gateway
         */
        $response = $sms->send($mobile, $templateId, [
            'var1' => $otp,
            'text' => $text,
        ]);

        /**
         * ❌ Gateway failure
         */
        if (($response['ErrorCode'] ?? null) !== '000') {
            return response()->json([
                'success' => false,
                'message' => 'SMS sending failed',
                'gateway_response' => $response
            ], 422);
        }

        /**
         * ✅ Success Response
         */
        return ApiResponse::success('SMS sent successfully', [
            'job_id' => $response['JobId'] ?? null,
            'existing_genders' => $existingGenders
        ]);
    }


    public function verify(Request $request)
    {
        $request->validate([
            'mobile' => 'required|digits:10',
            'otp' => 'required|digits:6',
            'type' => 'required|in:otp,first_time_login,forgot_password',
        ]);

        $mobile = '91' . $request->mobile;

        $otpRow = Otp::where('mobile', $mobile)
            ->where('type', $request->type)
            ->where('is_used', false)
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        if (!$otpRow || !Hash::check($request->otp, $otpRow->otp_hash)) {
            return ApiResponse::error('Invalid or expired OTP', 422);
        }

        // ✅ Mark OTP used
        $otpRow->update(['is_used' => true]);

        /**
         * 🔐 FORGOT PASSWORD FLOW
         */
        if ($request->type === 'forgot_password') {

            $resetToken = hash('sha256', Str::random(60));

            // Invalidate old reset tokens
            Token::where('phone', $request->mobile)
                ->where('type', 'password_reset')
                ->where('is_used', false)
                ->update(['is_used' => true]);

            Token::create([
                'token' => $resetToken,
                'phone' => $request->mobile,
                'type' => 'password_reset',
                'is_used' => false,
                'expires_at' => now()->addMinutes(10),
            ]);

            return ApiResponse::success([
                'reset_token' => $resetToken,
                'mobile' => $request->mobile,
            ], 'OTP verified successfully');
        }

        /**
         * 🔐 FIRST TIME LOGIN FLOW
         */
        $setupToken = hash('sha256', Str::random(60));

        Token::where('phone', $request->mobile)
            ->where('type', 'setup')
            ->where('is_used', false)
            ->update(['is_used' => true]);

        Token::create([
            'token' => $setupToken,
            'phone' => $request->mobile,
            'type' => 'setup',
            'is_used' => false,
            'expires_at' => now()->addMinutes(10),
        ]);

        return ApiResponse::success([
            'setup_token' => $setupToken,
            'mobile' => $request->mobile,
        ], 'OTP verified successfully');
    }


    public function completeSetup(Request $request)
    {
        $request->validate([
            'setup_token' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        try {
            $token = Token::where('token', $request->setup_token)
                ->where('type', 'setup')
                ->where('is_used', false)
                ->where('expires_at', '>', now())
                ->first();

            if (!$token || !$token->phone) {
                return ApiResponse::error('Invalid or expired setup token', 422);
            }

            $userRole = Role::where('name', 'user')->firstOrFail();


            // ✅ CREATE USER HERE
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $token->phone,
                'password' => Hash::make($request->password),
                'is_active' => true,
                'last_login_at' => now(),
                'role_id' => $userRole->id,
            ]);

            // ✅ Mark token as used
            $token->update(['is_used' => true]);

            return ApiResponse::success(null, 'Setup completed successfully');
        } catch (\Throwable $e) {
            Log::error('Setup failed', [
                'error' => $e->getMessage(),
            ]);

            return ApiResponse::error('Setup failed', $e->getMessage());
        }
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'reset_token' => 'required|string',
            'password' => 'required|min:6|confirmed',
            'gender' => 'required|in:male,female', // 🔥 Added gender
        ]);

        $token = Token::where('token', $request->reset_token)
            ->where('type', 'password_reset')
            ->where('is_used', false)
            ->where('expires_at', '>', now())
            ->first();

        if (!$token) {
            return ApiResponse::error('Invalid or expired token', 422);
        }

        // ✅ Find user by phone AND gender
        $user = User::where('phone', $token->phone)
            ->whereHas('profile', function($query) use ($request) {
                $query->where('gender', $request->gender);
            })
            ->first();

        if (!$user) {
            return ApiResponse::error('User with this gender not found for this mobile number', 404);
        }

        // ✅ UPDATE PASSWORD
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // ✅ MARK TOKEN USED
        $token->update(['is_used' => true]);

        return ApiResponse::success(null, 'Password reset successful');
    }
}
