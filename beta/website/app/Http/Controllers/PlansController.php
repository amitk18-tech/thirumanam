<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApiService;

class PlansController extends Controller
{
    protected $api;

    protected $staticPlans = [
        [
            'slug'                     => 'essential',
            'name'                     => 'Essential',
            'price'                    => '2048',
            'duration_days'            => 180,
            'profiles_view_allowed'    => 25,
            'sent_interest_allowed'    => 10,
            'messages_sent_allowed'    => 10,
            'soveran_show'             => 'Access profiles from 1 to 25 Sovrans',
        ],
        [
            'slug'                     => 'classic',
            'name'                     => 'Classic',
            'price'                    => '3073',
            'duration_days'            => 180,
            'profiles_view_allowed'    => 50,
            'sent_interest_allowed'    => 10,
            'messages_sent_allowed'    => 10,
            'soveran_show'             => 'Access profiles from 1 to 50 Sovrans',
        ],
        [
            'slug'                     => 'prime',
            'name'                     => 'Prime',
            'price'                    => '4097',
            'duration_days'            => 180,
            'profiles_view_allowed'    => 1000,
            'sent_interest_allowed'    => 10,
            'messages_sent_allowed'    => 10,
            'soveran_show'             => 'Access all profiles',
        ],
    ];

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    public function index()
    {
        $isLoggedIn  = session()->has('api_token');
        $currentSlug = 'default';
        $plans       = $this->staticPlans;

        if ($isLoggedIn) {
            $response    = $this->api->authGet('membership');
            $allPlans    = $response['data'] ?? [];
            $onlineSlugs = ['essential', 'classic', 'prime'];
            $livePlans   = array_values(array_filter($allPlans, fn($p) => in_array($p['slug'] ?? '', $onlineSlugs)));
            if (!empty($livePlans)) {
                $plans = $livePlans;
                // Add soveran_show to live plans if missing
                $soveranMap = [
                    'essential' => 'Access profiles from 1 to 25 Sovrans',
                    'classic'   => 'Access profiles from 1 to 50 Sovrans',
                    'prime'     => 'Access all profiles',
                ];
                $plans = array_map(function($p) use ($soveranMap) {
                    $p['soveran_show'] = $soveranMap[$p['slug']] ?? '';
                    return $p;
                }, $plans);
            }

            $meResponse  = $this->api->authGet('members/me');
            $currentSlug = $meResponse['data']['membership']['slug'] ?? 'default';
        }

        $hierarchy    = ['default' => 0, 'essential' => 1, 'classic' => 2, 'prime' => 3];
        $currentLevel = $hierarchy[$currentSlug] ?? 0;

        return view('plans', [
            'plans'        => $plans,
            'isLoggedIn'   => $isLoggedIn,
            'currentSlug'  => $currentSlug,
            'currentLevel' => $currentLevel,
            'hierarchy'    => $hierarchy,
        ]);
    }
}
