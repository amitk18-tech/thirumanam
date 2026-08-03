<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use App\Services\ApiService;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('layouts.app', function ($view) {
            $tickerNotifications = [];
            $tickerNotifCount = 0;
            $tickerMsgCount = 0;

            if (Session::has('api_token')) {
                try {
                    $api = app(ApiService::class);

                    // Fetch all notifications
                    $notifResponse = $api->getNotifications();
                    $allNotifications = $notifResponse['data'] ?? [];

                    // Count only notifications newer than last-seen cookie
                    $lastSeen = Cookie::get('notif_last_seen');
                    if ($lastSeen) {
                        $lastSeenTime = strtotime($lastSeen);
                        $tickerNotifCount = count(array_filter($allNotifications, function($n) use ($lastSeenTime) {
                            return strtotime($n['created_at']) > $lastSeenTime;
                        }));
                        $tickerNotifications = $tickerNotifCount > 0 ? $allNotifications : [];
                    } else {
                        $tickerNotifCount = count($allNotifications);
                        $tickerNotifications = $allNotifications;
                    }

                    // Message unread count — API returns data.count
                    $msgResponse = $api->getUnreadCount();
                    $rawMsg = $msgResponse['data']['count']
                        ?? $msgResponse['data']['unread_count']
                        ?? $msgResponse['count']
                        ?? 0;
                    $tickerMsgCount = is_numeric($rawMsg) ? (int)$rawMsg : 0;

                } catch (\Throwable $e) {
                    $tickerNotifications = [];
                    $tickerNotifCount = 0;
                    $tickerMsgCount = 0;
                }
            }

            $view->with('tickerNotifications', $tickerNotifications);
            $view->with('tickerNotifCount', $tickerNotifCount);
            $view->with('tickerMsgCount', $tickerMsgCount);
        });
    }
}
