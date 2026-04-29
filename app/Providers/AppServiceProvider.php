<?php

namespace App\Providers;

use App\Auth\JoomlaUserProvider;
use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Auth::provider('joomla', function ($app, array $config) {
            return new JoomlaUserProvider($app['hash'], $config['model']);
        });

        User::observe(UserObserver::class);
        Password::defaults(function () {
            return Password::min(5)
                /*      ->letters()
                      ->numbers()
                      ->symbols()
                      ->mixedCase()
                      ->uncompromised()*/;
        });
    }
}
