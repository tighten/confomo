<?php namespace Confomo\Entities;

use Confomo\Twitter\Images\Namer;

class Friend extends \Eloquent
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
        return $this->belongsTo('User');
    }

	public function twitterProfile()
	{
		return $this->hasOne('Confomo\Entities\TwitterProfile', 'twitter_id', 'twitter_id');
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
