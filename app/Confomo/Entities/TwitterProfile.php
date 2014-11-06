<?php namespace Confomo\Entities;

class TwitterProfile extends \Eloquent
{
    protected $guarded = [
        'id'
    ];

    const PROFILE_PICTURE_CACHE_PATH = '/assets/img/cache/twitter_profile_pics/';

    public function profilePicturePath()
    {
        self::PROFILE_PICTURE_CACHE_PATH . md5($this->twitter_id) . '.jpeg';
    }

    public function getProfilePictureCachePath()
    {
        return self::PROFILE_PICTURE_CACHE_PATH;
    }

    public function friend()
    {
        return $this->belongstoMany('Confomo\Entities\Friend');
    }
}
