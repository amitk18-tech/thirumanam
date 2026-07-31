<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
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

            if (Session::has('api_token')) {
                try {
                    $api = app(ApiService::class);
                    $countResponse = $api->getNotificationsCount();
                    $raw = $countResponse['count'] ?? $countResponse['data'] ?? 0; $tickerNotifCount = is_numeric($raw) ? (int)$raw : (is_array($raw) ? count($raw) : 0);
                    if ($tickerNotifCount > 0) {
                        $notifResponse = $api->getNotifications();
                        $tickerNotifications = $notifResponse['data'] ?? [];
                    }
                } catch (\Throwable $e) {
                    $tickerNotifications = [];
                    $tickerNotifCount = 0;
                }
            }

            $view->with('tickerNotifications', $tickerNotifications);
            $view->with('tickerNotifCount', $tickerNotifCount);
        });
    }
}
