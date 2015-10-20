<?php

namespace App;

use App\Services\Twitter\Images\Namer;
use Illuminate\Database\Eloquent\Model;

class TwitterProfile extends Model
{
    protected $guarded = [
        'id'
    ];

    public function profilePicturePath()
    {
        return Namer::getProfilePictureByTwitterId($this->twitter_id);
    }

    public function getProfilePictureCachePath()
    {
        return Namer::getProfilePictureCachePath();
    }

    public function friends()
    {
        return $this->belongstoMany(Friend::class);
    }
}
