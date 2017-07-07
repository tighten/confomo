<?php

namespace App;

use App\Jobs\FetchTwitterInfo;
use Illuminate\Database\Eloquent\Model;

class Tweeter extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        /**
         * When deleting a tweeter, delete the cached avatar from storage.
         * @todo
         * Currently not triggered; we need to clean out un-linked tweeters on a cron.
         */
        static::deleted(function ($tweeter) {
            if (file_exists($avatar_path = public_path($tweeter->avatar))) {
                @unlink($avatar_path);
            }
        });
    }

    public static function ensureExists($username)
    {
        \Bus::dispatch(new FetchTwitterInfo(self::firstOrCreate(['username' => $username])));
    }

    public function getAvatarAttribute()
    {
        return sprintf('assets/img/cache/twitter_profile_pics/%s', sha1($this->username));
    }

    public function getAvatarUrlAttribute()
    {
        return asset(sprintf('avatar/%s', $this->username));
    }
}
