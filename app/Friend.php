<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    protected $fillable = ['username', 'avatar', 'type', 'met', 'introduction'];
    protected $appends = ['avatar_url'];
    protected $casts = ['met' => 'boolean', 'introduction' => 'boolean'];

    protected static function boot()
    {
        parent::boot();

        /**
         * When deleting a friend, if they are the last friend record in the database
         * with the given username and they are not themselves a user, delete the
         * cached avatar from storage.
         */
        static::deleted(function ($friend) {
            if (! static::where('username', $friend->username)->exists() && ! User::where('twitter_nickname')->exists()) {
                if (file_exists($avatar_path = public_path($friend->avatar))) {
                    @unlink($avatar_path);
                }
            }
        });
    }

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
