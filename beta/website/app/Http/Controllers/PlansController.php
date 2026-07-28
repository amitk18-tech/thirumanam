<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApiService;

class PlansController extends Controller
{
    protected $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    public function index()
    {
        $response = $this->api->authGet('membership');
        $allPlans = $response['data'] ?? [];

        // Only show online plans
        $onlineSlugs = ['essential', 'classic', 'prime'];
        $plans = array_values(array_filter($allPlans, fn($p) => in_array($p['slug'], $onlineSlugs)));

        // Get current member plan
        $meResponse = $this->api->authGet('members/me');
        $currentSlug = $meResponse['data']['membership']['slug'] ?? 'default';

        // Plan hierarchy for upgrade logic
        $hierarchy = ['default' => 0, 'essential' => 1, 'classic' => 2, 'prime' => 3];
        $currentLevel = $hierarchy[$currentSlug] ?? 0;

        return view('plans', [
            'plans'        => $plans,
            'isLoggedIn'   => session()->has('api_token'),
            'currentSlug'  => $currentSlug,
            'currentLevel' => $currentLevel,
            'hierarchy'    => $hierarchy,
        ]);
    }
}
