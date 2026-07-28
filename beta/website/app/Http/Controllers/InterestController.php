<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApiService;

class InterestController extends Controller
{
    protected ApiService $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    public function index(Request $request)
    {
        $tab = $request->get('tab', 'sent');
        if (!in_array($tab, ['sent', 'received'])) {
            $tab = 'sent';
        }

        $response = $this->api->authGet('interaction/interests', ['type' => $tab]);
        $interests = $response['data'] ?? [];

        return view('interests.index', compact('interests', 'tab'));
    }
}
