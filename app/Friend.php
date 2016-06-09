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

    public function fetchAvatar()
    {
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
