<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    protected ApiService $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    public function show()
    {
        if (Session::has('api_token')) {
            return redirect('/dashboard');
        }
        return view('auth.register');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'mobile' => 'required|digits:10',
            'gender' => 'required|in:male,female',
        ]);

        $response = $this->api->sendOtp($request->mobile, $request->gender);

        if ($response['success'] ?? false) {
            $existingGenders = $response['data']['existing_genders'] ?? [];
            if (in_array($request->gender, $existingGenders)) {
                return response()->json([
                    'success' => false,
                    'message' => 'A ' . $request->gender . ' profile already exists for this mobile number. Please login instead.',
                ], 422);
            }
            return response()->json([
                'success' => true,
                'existing_genders' => $existingGenders,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $response['message'] ?? 'Failed to send OTP.',
        ], 422);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'mobile' => 'required|digits:10',
            'otp'    => 'required|digits:6',
        ]);

        $response = $this->api->verifyOtp($request->mobile, $request->otp);

        if ($response['success'] ?? false) {
            return response()->json([
                'success'     => true,
                'setup_token' => $response['message']['setup_token'] ?? null,
                'mobile'      => $response['message']['mobile'] ?? $request->mobile,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $response['message'] ?? 'Invalid or expired OTP.',
        ], 422);
    }

    public function complete(Request $request)
    {
        $request->validate([
            'setup_token' => 'required|string',
            'mobile'      => 'required|digits:10',
            'name'        => 'required|string|max:255',
            'email'       => 'required|email',
            'password'    => 'required|min:6',
            'gender'      => 'required|in:male,female',
        ]);

        $setup = $this->api->post('/setup/complete', [
            'setup_token' => $request->setup_token,
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => $request->password,
        ]);

        if (!($setup['success'] ?? false)) {
            return response()->json([
                'success' => false,
                'message' => $setup['message'] ?? 'Registration failed.',
            ], 422);
        }

        $login = $this->api->post('/auth/user/login', [
            'phone'    => $request->mobile,
            'password' => $request->password,
            'gender'   => $request->gender,
        ]);

        $token = $login['data']['token'] ?? null;
        $user  = $login['data']['user'] ?? null;

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Account created but login failed. Please login manually.',
            ], 422);
        }

        Session::put('api_token', $token);
        Session::put('user', $user);
        Session::put('register_gender', $request->gender);

        return response()->json([
            'success'  => true,
            'redirect' => '/register/profile',
        ]);
    }

    public function showProfileSetup()
    {
        if (!Session::has('api_token')) {
            return redirect('/register');
        }
        return view('auth.register-profile');
    }

    public function saveProfile(Request $request)
    {
        $request->validate([
            'gender'         => 'required|in:male,female',
            'dob'            => 'required|date',
            'marital_status' => 'required|string',
            'membership_type'=> 'required|string',
        ]);

        $user   = Session::get('user');
        $userId = $user['id'] ?? null;

        // Step 1: Save profile
        $response = $this->api->authPost('/profile', array_merge(
            $request->only([
                'gender', 'dob', 'marital_status', 'membership_type',
                'education', 'occupation', 'city', 'state',
            ]),
            ['user_id' => $userId]
        ));

        if (!($response['success'] ?? false)) {
            return response()->json([
                'success' => false,
                'message' => $response['message'] ?? 'Failed to save profile.',
            ], 422);
        }

        // Step 2: Save family details if provided
        $profileId  = $response['data']['id'] ?? null;
        $fatherName = $request->input('father_name');
        $motherName = $request->input('mother_name');

        if ($profileId && ($fatherName || $motherName)) {
            $this->api->authPost('/family-detail', array_filter([
                'profile_id'  => $profileId,
                'father_name' => $fatherName,
                'mother_name' => $motherName,
            ]));
        }

        Session::forget('register_gender');
        return response()->json(['success' => true, 'redirect' => '/dashboard']);
    }
}
