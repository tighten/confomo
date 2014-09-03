<?php namespace Confomo\Entities;

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
		return $this->belongsTo('Confomo\Entities\TwitterProfile', 'twitter_id', 'twitter_id');
	}

	public function getTwitterProfilePicAttribute()
	{
		// @todo: How can we refactor this? statics & ugliness..
		$file_name = $this->twitter_id ? md5($this->twitter_id) . '.jpeg' : 'blank.jpg';
		return TwitterProfile::PROFILE_PICTURE_CACHE_PATH . $file_name;
	}

	public function scopeFromConference($query, $conference_id)
	{
		return $query->where('conference_id', $conference_id);
	}
}
