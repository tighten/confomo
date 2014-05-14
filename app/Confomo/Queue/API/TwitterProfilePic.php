<?php namespace Confomo\Queue\API;

use Thujohn\Twitter\Twitter;
use Illuminate\Cache\CacheManager as Cache;
use TwitterProfile;
use Friend;

class TwitterProfilePic
{
	protected $twitter;
	protected $cache;
	protected $profile;
	protected $friend;

	// In minutes; 
	const PULL_CACHE_LENGTH = 10080;

	public function __construct(Twitter $twitter, Cache $cache, TwitterProfile $profile, Friend $friend)
	{
		$this->twitter = $twitter;
		$this->cache = $cache;
		$this->profile = $profile;
		$this->friend = $friend;
	}

	public function fire($job, $data)
	{
		$twitter_handle = $data['twitter_handle'];
		$friend_id = $data['friend_id'];

		// @todo: Look up if we already have a TwitterProfile updated in the last week
		// (using that for cache; we can't cache by twitter handle because it changes
		// too often)

		$twitter_profile = $this->twitter->getUsersLookup([
			'screen_name' => $twitter_handle
		]);

		if ($twitter_profile === null) {
			// @todo: Show some type of notice maybe?
			\App::abort(500);
		}
		if ( ! is_array($twitter_profile) && isset($twitter_profile->errors)) {
			// @todo: return $twitter_profile->errors[0]->message
			\App::abort(500);
		}

		$twitter_profile = $twitter_profile[0];

		// @todo: Store when last pulled somewhere (is just on the put expiration date maybe?)

		$this->saveTwitterProfile($twitter_profile);

		$this->linkTwitterProfileToFriend($twitter_profile, $friend_id);

		// @todo: Store twitter user ID with each friend so it doesn't break if they change their username later
		$this->saveTwitterProfileImageLocally($twitter_profile);

		$job->delete();
	}

	protected function linkTwitterProfileToFriend(\stdClass $twitter_profile, $friend_id)
	{
		$friend = $this->friend->findOrFail($friend_id);
		$friend->twitter_id = $twitter_profile->id;
		$friend->save();
	}

	protected function saveTwitterProfile(\stdClass $twitter_profile)
	{
		$profile = $this->profile->firstOrCreate([
			'twitter_id' => $twitter_profile->id
		]);

		$profile->name = $twitter_profile->name;
		$profile->screen_name = $twitter_profile->screen_name;
		$profile->location = $twitter_profile->location;
		$profile->description = $twitter_profile->description;
		$profile->url = $twitter_profile->url;
		$profile->profile_image_url = $twitter_profile->profile_image_url;
		$profile->profile_image_url_https = $twitter_profile->profile_image_url_https;

		$profile->save();
	}

	protected function saveTwitterProfileImageLocally(\stdClass $twitter_profile)
	{
		$path_prefix = \App::runningInConsole() ? base_path() . '/public/' : '';
		copy(
			$twitter_profile->profile_image_url,
			$path_prefix . $this->profile->getProfilePictureCachePath() . md5($twitter_profile->id) . '.jpeg'
		);
	}
}


/*

array(1) {
	[0]=>
	object(stdClass)#218 (41) {
		["id"]=>
		int(14280918)
		["id_str"]=>
		string(8) "14280918"
		["name"]=>
		string(13) "Matt Stauffer"
		["screen_name"]=>
		string(12) "stauffermatt"
		["location"]=>
		string(21) "DTWâœˆGNVâœˆORDâœˆGNV"
		["description"]=>
		string(151) "Trying to find the sacred wherever it is to be found.

Partner @tightenco, Founder @karaniapp, VP SocialPack | Developer | Bassist | Husband | Father"
		["url"]=>
		string(22) "http://t.co/m6LAl5Aedx"
		["entities"]=>
		object(stdClass)#217 (2) {
			["url"]=>
			object(stdClass)#216 (1) {
				["urls"]=>
				array(1) {
					[0]=>
					object(stdClass)#222 (4) {
						["url"]=>
						string(22) "http://t.co/m6LAl5Aedx"
						["expanded_url"]=>
						string(23) "http://mattstauffer.co/"
						["display_url"]=>
						string(15) "mattstauffer.co"
						["indices"]=>
						array(2) {
							[0]=>
							int(0)
							[1]=>
							int(22)
						}
					}
				}
			}
			["description"]=>
			object(stdClass)#221 (1) {
				["urls"]=>
				array(0) {
				}
			}
		}
		["protected"]=>
		bool(false)
		["followers_count"]=>
		int(1038)
		["friends_count"]=>
		int(373)
		["listed_count"]=>
		int(52)
		["created_at"]=>
		string(30) "Wed Apr 02 05:49:52 +0000 2008"
		["favourites_count"]=>
		int(2123)
		["utc_offset"]=>
		int(-14400)
		["time_zone"]=>
		string(26) "Eastern Time (US & Canada)"
		["geo_enabled"]=>
		bool(false)
		["verified"]=>
		bool(false)
		["statuses_count"]=>
		int(15139)
		["lang"]=>
		string(2) "en"
		["status"]=>
		object(stdClass)#220 (21) {
			["created_at"]=>
			string(30) "Tue May 13 04:02:44 +0000 2014"
			["id"]=>
			int(466065983447121921)
			["id_str"]=>
			string(18) "466065983447121921"
			["text"]=>
			string(139) "@artisangoose Haha, how small can you take? Some friends and me often get $2000-5000 type jobs that we just canâ€™t take. Letâ€™s talk tmrw"
			["source"]=>
			string(86) "<a href="http://tapbots.com/software/tweetbot/mac" rel="nofollow">Tweetbot for Mac</a>"
			["truncated"]=>
			bool(false)
			["in_reply_to_status_id"]=>
			int(466061913395175425)
			["in_reply_to_status_id_str"]=>
			string(18) "466061913395175425"
			["in_reply_to_user_id"]=>
			int(2164931628)
			["in_reply_to_user_id_str"]=>
			string(10) "2164931628"
			["in_reply_to_screen_name"]=>
			string(12) "artisangoose"
			["geo"]=>
			NULL
			["coordinates"]=>
			NULL
			["place"]=>
			NULL
			["contributors"]=>
			NULL
			["retweet_count"]=>
			int(0)
			["favorite_count"]=>
			int(0)
			["entities"]=>
			object(stdClass)#224 (4) {
				["hashtags"]=>
				array(0) {
				}
				["symbols"]=>
				array(0) {
				}
				["urls"]=>
				array(0) {
				}
				["user_mentions"]=>
				array(1) {
					[0]=>
					object(stdClass)#225 (5) {
						["screen_name"]=>
						string(12) "artisangoose"
						["name"]=>
						string(16) "Adam Engebretson"
						["id"]=>
						int(2164931628)
						["id_str"]=>
						string(10) "2164931628"
						["indices"]=>
						array(2) {
							[0]=>
							int(0)
							[1]=>
							int(13)
						}
					}
				}
			}
			["favorited"]=>
			bool(false)
			["retweeted"]=>
			bool(false)
			["lang"]=>
			string(2) "en"
		}
		["contributors_enabled"]=>
		bool(false)
		["is_translator"]=>
		bool(false)
		["is_translation_enabled"]=>
		bool(false)
		["profile_background_color"]=>
		string(6) "00141E"
		["profile_background_image_url"]=>
		string(70) "http://pbs.twimg.com/profile_background_images/38494297/Untitled-2.jpg"
		["profile_background_image_url_https"]=>
		string(71) "https://pbs.twimg.com/profile_background_images/38494297/Untitled-2.jpg"
		["profile_background_tile"]=>
		bool(false)
		["profile_image_url"]=>
		string(79) "http://pbs.twimg.com/profile_images/2386258261/o286i7vo6xwri0xyuwf8_normal.jpeg"
		["profile_image_url_https"]=>
		string(80) "https://pbs.twimg.com/profile_images/2386258261/o286i7vo6xwri0xyuwf8_normal.jpeg"
		["profile_banner_url"]=>
		string(57) "https://pbs.twimg.com/profile_banners/14280918/1351525800"
		["profile_link_color"]=>
		string(6) "ED6A1E"
		["profile_sidebar_border_color"]=>
		string(6) "000000"
		["profile_sidebar_fill_color"]=>
		string(6) "252429"
		["profile_text_color"]=>
		string(6) "6B6666"
		["profile_use_background_image"]=>
		bool(false)
		["default_profile"]=>
		bool(false)
		["default_profile_image"]=>
		bool(false)
		["following"]=>
		bool(false)
		["follow_request_sent"]=>
		bool(false)
		["notifications"]=>
		bool(false)
	}
}

 */
