<?php

namespace App;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Abraham\TwitterOAuth\TwitterOAuth;

class Friend extends Model
{
    protected $fillable = ['username', 'avatar', 'type', 'met'];
    protected $casts = [
        'met' => 'boolean'
    ];

    public static function boot()
    {
        parent::boot();

        /**
         * When deleting a friend, if they are the last record in the database,
         * they have an avatar set, and they are the last record with this 
         * username, also remove the cached twitter avatar from storage.
         */
        static::deleted(function ($friend) {
            if (static::where('username', $friend->username)->count() == 0) {
                if ($friend->avatar && file_exists($avatar_path = public_path($friend->avatar))) {
                    @unlink($avatar_path);
                }
            }
        });
    }

    public function fetchAvatar()
    {
        // If the friend already exists, use the existing avatar
        if ($friend = Friend::where('username', $this->username)->whereNotNull('avatar')->first()) {
            return $this->update(['avatar' => $friend->avatar]);
        }

        try {
            $twitter = app(TwitterOAuth::class);
            $details = $twitter->get('users/show', ['screen_name' => $this->username]);

            $url = str_replace('_normal', '', $details->profile_image_url_https);
            $extension = pathinfo($url, PATHINFO_EXTENSION);
            $path = sprintf('assets/img/cache/twitter_profile_pics/%s.%s', $this->username, $extension);

            if (@file_put_contents(public_path($path), @file_get_contents($url))) {
                return $this->update(['avatar' => $path]);
            }
        } catch (Exception $e) {
            // No big deal
            return false;
        }
    }

    public function markMet()
    {
        return $this->update(['met' => true]);
    }
}
