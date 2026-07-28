<?php

namespace App\Services\Auth;

// use App\Models\ScrumMasterModels\User;
use App\Models\User;
use App\Mail\EmailVerificationCode;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class AuthEmailService
{
    public function register(array $data)
    {
        $otp = rand(100000, 999999);

        $user = User::create([
            'username' => $data['username'] ?? null,
            'email' => $data['email']   ?? null,
            'phone_number' => $data['phone'] ?? null,
            'role_id' => $data['role_id'] ?? 1,
            'password' => Hash::make($data['password']),
            'verification_code' => $otp,
            'code_expires_at' => Carbon::now()->addMinutes(10),
            'verified' => false,
        ]);

        $this->sendOtp($user);

        return $user;
    }

    public function sendOtp(User $user): void
    {
        Mail::to($user->email)->send(new EmailVerificationCode($user));
    }

    public function verifyCode(array $data): array
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            return ['success' => false, 'message' => 'User not found.'];
        }

        if ($user->verified) {
            return ['success' => true, 'message' => 'Email already verified.'];
        }

        if (Carbon::now()->greaterThan($user->code_expires_at)) {
            return ['success' => false, 'message' => 'OTP has expired.'];
        }

        if ($user->verification_code !== $data['code']) {
            $user->increment('otp_attempts');
            return ['success' => false, 'message' => 'Invalid OTP code.'];
        }

        $user->update([
            'verified' => true,
            'verification_code' => null,
            'code_expires_at' => null,
            'otp_attempts' => 0,
        ]);

        return ['success' => true, 'message' => 'Email verified successfully.'];
    }

    public function resendCode(array $data): array
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            return ['success' => false, 'message' => 'User not found.'];
        }

        if ($user->verified) {
            return ['success' => false, 'message' => 'User already verified.'];
        }

        $otp = rand(100000, 999999);

        $user->update([
            'verification_code' => $otp,
            'code_expires_at' => now()->addMinutes(10),
            'otp_attempts' => 0,
        ]);

        $this->sendOtp($user);

        return ['success' => true, 'message' => 'OTP resent successfully.'];
    }

    public function login(array $data): array
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            return ['success' => false, 'message' => 'User not found.'];
        }

        if (!Hash::check($data['password'], $user->password)) {
            return ['success' => false, 'message' => 'Invalid credentials.'];
        }

        if (!$user->verified) {
            return ['success' => false, 'message' => 'Email not verified.'];
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'success' => true,
            'message' => 'Login successful.',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'role_id' => $user->role_id,
                'role_name' => $user->role->name ?? null,
                'verified' => $user->verified,
                'status' => $user->status,
                'profile_picture' => $user->profile_picture,
            ]
        ];
    }

    public function logout(): array
    {
        $user = Auth::user();

        if (!$user) {
            return ['success' => false, 'message' => 'User not authenticated.'];
        }

        $user->tokens()->delete(); // Revoke all tokens

        return ['success' => true, 'message' => 'Logout successful.'];
    }
}