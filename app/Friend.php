<?php

namespace App;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Abraham\TwitterOAuth\TwitterOAuth;

class Friend extends Model
{
    protected $fillable = ['username', 'avatar', 'type', 'met'];
    protected $appends = ['avatar_url'];
    protected $casts = ['met' => 'boolean'];

    public function getAvatarAttribute()
    {
        return sprintf('assets/img/cache/twitter_profile_pics/%s', sha1($this->username));
    }

    public function getAvatarUrlAttribute()
    {
        return asset(sprintf('avatar/%s', $this->username));
    }

    public function markMet()
    {
        return $this->update(['met' => true]);
    }
}
