<?php

namespace Bits\Package\Providers;

use Illuminate\Support\ServiceProvider;
use Bits\Package\Services\SmsGatewayHubService;
use Bits\Package\Services\HotelManagement\CancellationPolicyService;


class BitsServiceProvider extends ServiceProvider
{
    public function register()
    {
        // 🔥 ADD THIS
        $this->app->singleton(SmsGatewayHubService::class, function () {
            return new SmsGatewayHubService();
        });

        $this->app->singleton(CancellationPolicyService::class, function () {
            return new CancellationPolicyService();
        });
    }
}
