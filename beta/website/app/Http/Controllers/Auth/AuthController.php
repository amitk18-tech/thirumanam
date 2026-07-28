<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    protected ApiService $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    public function showLogin()
    {
        if (Session::has('api_token')) {
            return redirect('/dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'phone'    => 'required|string',
            'password' => 'required|string',
        ]);

        $response = $this->api->login($request->phone, $request->password);

        $token = $response['data']['token'] ?? $response['token'] ?? null;
        $user  = $response['data']['user'] ?? $response['user'] ?? null;

        // Single profile — login directly
        if ($token && $user) {
            Session::put('api_token', $token);
            Session::put('api_user', $user);
            return redirect('/dashboard');
        }

        // Multiple profiles — show gender selector
        $loginStatus = $response['data']['login_status'] ?? null;
        if ($loginStatus === 'multiple_profiles') {
            $profiles = $response['data']['profiles'] ?? [];

            // Only show selector if more than one profile is active
            $activeProfiles = array_filter($profiles, fn($p) => ($p['status'] ?? 'active') === 'active');

            if (count($activeProfiles) > 1) {
                Session::put('pending_phone', $request->phone);
                Session::put('pending_password', $request->password);
                Session::put('pending_profiles', array_values($activeProfiles));
                return redirect('/login/select-profile');
            }

            // Only one active — login with that one directly
            if (count($activeProfiles) === 1) {
                $activeProfile = array_values($activeProfiles)[0];
                $gender = $activeProfile['gender'];
                return $this->loginWithGender($request->phone, $request->password, $gender);
            }
        }

        // Login succeeded but no profile yet — need to create one
        $existingGenders = $response['data']['existing_genders'] ?? null;
        $noProfile = $response['success'] === true
            && is_array($existingGenders)
            && count($existingGenders) === 0;

        if ($noProfile) {
            Session::put('pending_phone', $request->phone);
            return redirect('/register/profile')->with('info', 'Please complete your profile to continue.');
        }

        $error = $response['message'] ?? $response['data']['message'] ?? 'Invalid phone number or password.';
        return back()->withInput()->withErrors(['login' => $error]);
    }

    public function showSelectProfile()
    {
        $profiles = Session::get('pending_profiles');
        if (!$profiles) {
            return redirect('/login');
        }
        return view('auth.select-profile', ['profiles' => $profiles]);
    }

    public function submitSelectProfile(Request $request)
    {
        $request->validate(['gender' => 'required|in:male,female']);

        $phone    = Session::get('pending_phone');
        $password = Session::get('pending_password');

        if (!$phone || !$password) {
            return redirect('/login')->withErrors(['login' => 'Session expired. Please login again.']);
        }

        return $this->loginWithGender($phone, $password, $request->gender);
    }

    private function loginWithGender(string $phone, string $password, string $gender)
    {
        $response = $this->api->post('/auth/user/login', [
            'phone'    => $phone,
            'password' => $password,
            'gender'   => $gender,
        ]);

        $token = $response['data']['token'] ?? $response['token'] ?? null;
        $user  = $response['data']['user'] ?? $response['user'] ?? null;

        if ($token && $user) {
            Session::forget(['pending_phone', 'pending_password', 'pending_profiles']);
            Session::put('api_token', $token);
            Session::put('api_user', $user);
            return redirect('/dashboard');
        }

        return redirect('/login')->withErrors(['login' => 'Login failed. Please try again.']);
    }

    public function logout()
    {
        Session::flush();
        return redirect('/login')->with('success', 'Logged out successfully.');
    }
}
