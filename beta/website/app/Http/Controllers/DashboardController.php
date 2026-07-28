<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApiService;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    protected ApiService $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    public function index()
    {
        $user = Session::get('api_user');

        $meResponse = $this->api->getMyProfile();
        $profile = $meResponse['data'] ?? null;

        // Fetch correct membership name from members/me (profiles table has stale membership_type)
        $memberResponse = $this->api->authGet('members/me');
        $membershipName = $memberResponse['data']['membership']['name'] ?? null;

        $member = [
            'name'                       => $profile['user']['name'] ?? $user['name'] ?? 'Member',
            'member_no'                  => $profile['member_no'] ?? null,
            'is_profile_complete'        => $profile['user']['is_profile_complete'] ?? false,
            'membership_expired'         => false,
            'end_date'                   => null,
            'profile'                    => [
                'membership_type' => $profile['membership_type'] ?? 'default',
                'membership_name' => $membershipName ?? ucfirst($profile['membership_type'] ?? 'Default'),
                'profile_photo'   => $profile['profile_photo'] ?? null,
            ],
            'interests_sent'             => $profile['interests_sent_count'] ?? 0,
            'interests_received'         => $profile['interests_received_count'] ?? 0,
            'profiles_viewed'            => ($meResponse['data']['profiles_view_allowed'] ?? 0) - ($meResponse['data']['profiles_view_remaining'] ?? 0),
            'profiles_view_remaining'    => $meResponse['data']['profiles_view_remaining'] ?? null,
            'profiles_view_allowed'      => $meResponse['data']['profiles_view_allowed'] ?? null,
            'sent_interest_remaining'    => $meResponse['data']['sent_interest_remaining'] ?? null,
            'sent_interest_allowed'      => $meResponse['data']['sent_interest_allowed'] ?? null,
            'messages_sent_remaining'    => $meResponse['data']['messages_sent_remaining'] ?? null,
            'messages_sent_allowed'      => $meResponse['data']['messages_sent_allowed'] ?? null,
        ];

        // Enrich session with latest name and photo for navbar
        if ($profile) {
            $currentUser = Session::get('api_user', []);
            $currentUser['name'] = $profile['user']['name'] ?? $currentUser['name'] ?? 'Member';
            $currentUser['profile_photo'] = $profile['profile_photo'] ?? null;
            Session::put('api_user', $currentUser);
        }

        $notifResponse = $this->api->getNotificationsCount();
        $notifCount = $notifResponse['data']['count'] ?? $notifResponse['count'] ?? 0;

        return view('dashboard', compact('user', 'member', 'notifCount'));
    }
}
