<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    protected $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    public function showPhone()
    {
        return view('auth.forgot-password');
    }

    public function sendOtp(Request $request)
    {
        $request->validate(['mobile' => 'required|digits:10']);

        $response = $this->api->post('send-sms', [
            'mobile' => $request->mobile,
            'type'   => 'forgot_password',
        ]);

        if ($response['success'] ?? false) {
            session(['fp_mobile' => $request->mobile]);
            return redirect('/forgot-password/verify');
        }

        return back()->withErrors(['mobile' => $response['message'] ?? 'Failed to send OTP.'])->withInput();
    }

    public function showVerify()
    {
        if (!session('fp_mobile')) {
            return redirect('/forgot-password');
        }
        return view('auth.forgot-verify');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|digits:6']);

        $mobile = session('fp_mobile');
        if (!$mobile) {
            return redirect('/forgot-password');
        }

        $response = $this->api->post('verify-sms', [
            'mobile' => $mobile,
            'otp'    => $request->otp,
            'type'   => 'forgot_password',
        ]);

        if ($response['success'] ?? false) {
            session(['fp_reset_token' => $response['message']['reset_token']]);
            return redirect('/forgot-password/reset');
        }

        return back()->withErrors(['otp' => $response['message'] ?? 'Invalid OTP.']);
    }

    public function showReset()
    {
        if (!session('fp_reset_token')) {
            return redirect('/forgot-password');
        }
        return view('auth.forgot-reset');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
            'gender'   => 'required|in:male,female',
        ]);

        $token = session('fp_reset_token');
        if (!$token) {
            return redirect('/forgot-password');
        }

        $response = $this->api->post('setup/reset-password', [
            'reset_token'           => $token,
            'password'              => $request->password,
            'password_confirmation' => $request->password_confirmation,
            'gender'                => $request->gender,
        ]);

        if ($response['success'] ?? false) {
            session()->forget(['fp_mobile', 'fp_reset_token']);
            return redirect('/login')->with('success', 'Password reset successfully. Please login.');
        }

        return back()->withErrors(['password' => $response['message'] ?? 'Failed to reset password.']);
    }
}
