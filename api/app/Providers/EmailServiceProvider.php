<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Auth\EmailAuthService;
use App\Services\EmailService;
use Illuminate\Support\Facades\App;
use App\Repositories\EmailVerificationRepository;

class EmailServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
    //     $this->app->bind(UserRepository::class, function ($app) {
    //         return new UserRepository(); // new UserRepository(new User())
    //     });

    //     $this->app->bind(EmailService::class, function ($app) {
    //         return new EmailService();
    //     });

    //     $this->app->bind(EmailVerificationRepository::class, function ($app) {
    //         return new EmailVerificationRepository();
    //     });

    //     $this->app->bind(EmailAuthService::class, function ($app) {
    //         return new EmailAuthService(
    //             $app->make(UserRepository::class), // new UserRepository()
    //             $app->make(EmailService::class),
    //             $app->make(EmailVerificationRepository::class)
    //         );
    //     });
     }



    /**
     * Bootstrap services.
     */
    public function boot()
    {
        //
    }
}
