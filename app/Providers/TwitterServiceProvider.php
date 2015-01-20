<?php namespace Confomo\Providers;

use Config;
use Illuminate\Support\ServiceProvider;

class TwitterServiceProvider extends ServiceProvider
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

    public function register()
    {
        // l5 HACK WTF
        Config::set('twitter::API_VERSION', '1.1');
        Config::set('twitter::CONSUMER_KEY', env('TWITTER_CONSUMER_KEY'));
        Config::set('twitter::CONSUMER_SECRET', env('TWITTER_CONSUMER_SECRET'));
        Config::set('twitter::ACCESS_TOKEN', env('TWITTER_ACCESS_TOKEN'));
        Config::set('twitter::ACCESS_TOKEN_SECRET', env('TWITTER_ACCESS_TOKEN_SECRET'));
        Config::set('twitter::USE_SSL', true);
    }

}




