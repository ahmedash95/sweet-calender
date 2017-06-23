<?php

namespace App\Providers;

use App\Services\GoogleCalender;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(GoogleCalender::class, function () {
            return new GoogleCalender(
                json_encode([
                    'access_token' => \Auth::user()->getTokenFor('google'),
                    'refresh_token' => \Auth::user()->getRefreshTokenFor('google'),
                    'expires_in' => \Auth::user()->getExpireTimeFor('google')
                ]),
                Auth::user()
            );
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
