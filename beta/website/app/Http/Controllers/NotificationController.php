<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApiService;

class NotificationController extends Controller
{
    public function index(ApiService $api)
    {
        $response = $api->getNotifications();
        $notifications = $response['data'] ?? [];

        // Sort by created_at descending
        usort($notifications, fn($a, $b) => strtotime($b['created_at']) - strtotime($a['created_at']));

        return view('notifications.index', compact('notifications'));
    }
}
