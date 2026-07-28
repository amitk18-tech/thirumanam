<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApiService;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    protected ApiService $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    public function index()
    {
        $isLoggedIn = Session::has('api_token');
        $members = [];

        if ($isLoggedIn) {
            $response = $this->api->getHomePageData();
            $members = $response['data'] ?? [];
        }

        return view('home', compact('members', 'isLoggedIn'));
    }
}
