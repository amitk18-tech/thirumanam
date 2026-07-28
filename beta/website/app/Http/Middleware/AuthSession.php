<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;

class AuthSession
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('api_token')) {
            return redirect('/login')->with('error', 'Please login to continue.');
        }

        $token   = Session::get('api_token');
        $baseUrl = rtrim(Config::get('services.api.base_url'), '/') . '/';

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept'        => 'application/json',
            ])->get($baseUrl . 'members/me');

            if ($response->status() === 401 || $response->status() === 403) {
                Session::flush();
                return redirect('/login')->with('error', 'Your session has expired. Please login again.');
            }

            // members/me returns: { data: { ...memberFields, profile: { profile_photo, user: { name } } } }
            $data        = $response->json();
            $memberData  = $data['data'] ?? [];
            $profile     = $memberData['profile'] ?? [];
            $userName    = $profile['user']['name'] ?? null;
            $photoRaw    = $profile['profile_photo'] ?? null;

            $sessionUser = Session::get('user', []);
            if ($userName) {
                $sessionUser['name'] = $userName;
            }
            if ($photoRaw) {
                $sessionUser['profile_photo'] = str_starts_with($photoRaw, 'http')
                    ? $photoRaw
                    : 'https://api.thirumanam.info/' . ltrim($photoRaw, '/');
            }
            Session::put('user', $sessionUser);

        } catch (\Throwable $e) {
            // If API is unreachable, allow through to avoid locking out users
        }

        return $next($request);
    }
}
