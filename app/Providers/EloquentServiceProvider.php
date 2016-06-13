<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Friend;

class EloquentServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * When deleting a friend, if they are the last record in the database
         * with the given username, delete the cached avatar from storage.
         */
        Friend::deleted(function ($friend) {
            if (! static::where('username', $friend->username)->exists()) {
                if (file_exists($avatar_path = public_path($friend->avatar))) {
                    @unlink($avatar_path);
                }
            }
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
