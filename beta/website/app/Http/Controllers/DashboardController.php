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

    // Single call to members/me — correct structure
    $meResponse = $this->api->authGet('members/me');
    $meData     = $meResponse['data'] ?? [];
    $profile    = $meData['profile'] ?? [];

    $member = [
        'name'                    => $profile['user']['name'] ?? $user['name'] ?? 'Member',
        'member_no'               => $meData['member_no'] ?? null,
        'is_profile_complete'     => $meData['is_profile_complete'] ?? false,
        'membership_expired'      => $meData['membership_expired'] ?? false,
        'end_date'                => $meData['end_date'] ?? null,
        'profile' => [
            'membership_type' => $profile['membership_type'] ?? 'default',
            'membership_name' => $meData['membership']['name'] ?? ucfirst($profile['membership_type'] ?? 'Default'),
            'profile_photo'   => $profile['profile_photo']
                ? (str_starts_with($profile['profile_photo'], 'http')
                    ? $profile['profile_photo']
                    : 'https://api.thirumanam.info/' . $profile['profile_photo'])
                : null,
        ],
        'interests_sent'          => $profile['interests_sent_count'] ?? 0,
        'interests_received'      => $profile['interests_received_count'] ?? 0,
        'profiles_viewed'         => ($meData['profiles_view_allowed'] ?? 0) - ($meData['profiles_view_remaining'] ?? 0),
        'shortlisted_count'       => $profile['shortlisted_profiles_count'] ?? 0,
        'following_count'         => $profile['following_count'] ?? 0,
        'followers_count'         => $profile['followers_count'] ?? 0,
        'profiles_view_remaining' => $meData['profiles_view_remaining'] ?? null,
        'profiles_view_allowed'   => $meData['profiles_view_allowed'] ?? null,
        'sent_interest_remaining' => $meData['sent_interest_remaining'] ?? null,
        'sent_interest_allowed'   => $meData['sent_interest_allowed'] ?? null,
        'messages_sent_remaining' => $meData['messages_sent_remaining'] ?? null,
        'messages_sent_allowed'   => $meData['messages_sent_allowed'] ?? null,
    ];

    // Enrich session
    if ($profile) {
        $currentUser = Session::get('api_user', []);
        $currentUser['name'] = $profile['user']['name'] ?? $currentUser['name'] ?? 'Member';
        $currentUser['profile_photo'] = $member['profile']['profile_photo'] ?? null;
        Session::put('api_user', $currentUser);
    }

    $notifResponse = $this->api->getNotificationsCount();
    $notifCount    = $notifResponse['data']['count'] ?? $notifResponse['count'] ?? 0;

    return view('dashboard', compact('user', 'member', 'notifCount'));
}
}
