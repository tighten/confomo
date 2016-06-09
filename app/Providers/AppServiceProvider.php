<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Abraham\TwitterOAuth\TwitterOAuth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Abraham\TwitterOAuth\TwitterOAuth', function () {
            return new TwitterOAuth(
                env('TWITTER_CONSUMER_KEY'),
                env('TWITTER_CONSUMER_SECRET'),
                env('TWITTER_ACCESS_TOKEN'),
                env('TWITTER_ACCESS_TOKEN_SECRET')
            );
        });
    }
}
