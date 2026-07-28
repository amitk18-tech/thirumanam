<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\UserRepository;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Bind the UserRepository class
        $this->app->bind(UserRepository::class, function ($app) {
            return new UserRepository($app->make(User::class));
        });

        // // Bind the AuthService class
        // $this->app->bind(AuthService::class, function ($app) {
        //     return new AuthService($app->make(UserRepository::class));
        // });

    }



    public function boot()
    {
        //
    }
}