<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Password reset link in email template...
        ResetPassword::createUrlUsing(static function ($notifiable, $token) {
            // Url of the fronted app for resetting password...
            return env('APP_URL').'/reset-password/'.$token;
        });
    }
}
