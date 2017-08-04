<?php

namespace App\Providers;

use Abraham\TwitterOAuth\TwitterOAuth;
use Doctrine\DBAL\Types\DateTimeType as DoctrineDateTimeType;
use Doctrine\DBAL\Types\Type as DoctrineType;
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
        if (! array_key_exists('timestamp', DoctrineType::getTypesMap())) {
            DoctrineType::addType('timestamp', DoctrineDateTimeType::class);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(TwitterOAuth::class, function () {
            return new TwitterOAuth(
                config('services.twitter.consumer_key'),
                config('services.twitter.consumer_secret'),
                config('services.twitter.access_token'),
                config('services.twitter.access_secret')
            );
        });
    }
}
