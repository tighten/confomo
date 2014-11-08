<?php namespace Confomo\Entities;

use Confomo\Twitter\Images\Namer;

class TwitterProfile extends \Eloquent
{
    protected $guarded = [
        'id'
    ];

    public function profilePicturePath()
    {
        Namer::getProfilePictureCachePath() . md5($this->twitter_id) . '.jpeg';
    }

    public function getProfilePictureCachePath()
    {
        return Namer::getProfilePictureCachePath();
    }

    public function friends()
    {
        return $this->belongstoMany('Confomo\Entities\Friend');
    }
}
