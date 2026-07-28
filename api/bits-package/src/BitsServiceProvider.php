<?php

namespace Bits\Package;

use Illuminate\Support\ServiceProvider;
use Bits\Package\Console\Commands\MakeModule;

use Bits\Package\Providers\ModulesServiceProvider;

class BitsServiceProvider extends ServiceProvider
{
    public function register()
    {

        $this->mergeConfigFrom(
            __DIR__ . '/config/razorpay.php',
            'razorpay'
        );

        $this->mergeConfigFrom(
            __DIR__ . '/config/sms.php',
            'sms'
        );

        $this->mergeConfigFrom(
            __DIR__ . '/config/hotel-cancellation.php',
            'hotel-cancellation'
        );

        // Bind services
        $this->app->register(ModulesServiceProvider::class);
    }


    public function boot()
    {
        // Load package migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'bits-package');
        // $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/routes/api.php');

        // Register Commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeModule::class
            ]);
        }
    }
}
