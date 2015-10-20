<?php

namespace App;

use Confomo\Twitter\Images\Namer;
use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'twitter',
        'type',
        'notes',
        'met'
    ];

    /**
     * Add to toArray
     *
     * @var array
     */
    protected $appends = [
        'twitter_profile_pic'
    ];

    public function friender()
    {
        return $this->belongsTo(User::class);
    }

	public function twitterProfile()
	{
		return $this->hasOne(TwitterProfile::class, 'twitter_id', 'twitter_id');
	}

    public function getTwitterProfilePicAttribute()
    {
        return Namer::getProfilePictureByTwitterId($this->twitter_id);
    }

    public function scopeFromConference($query, $conference_id)
    {
        return $query->where('conference_id', $conference_id);
    }
}
