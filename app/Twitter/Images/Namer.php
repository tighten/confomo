<?php  namespace Confomo\Twitter\Images; 

class Namer
{
    const PROFILE_PICTURE_CACHE_PATH = '/assets/img/cache/twitter_profile_pics/';

    public static function getProfilePictureCachePath()
    {
        return self::PROFILE_PICTURE_CACHE_PATH;
    }

    /**
     * Get the local file link for a profile page (or blank default) given a
     * twitterProfile id
     *
     * @param integer|null $twitterId
     * @return string
     */
    public static function getProfilePictureByTwitterId($twitterId)
    {
        $fileName = $twitterId ? md5($twitterId) . '.jpeg' : 'blank.jpg';

        return self::getProfilePictureCachePath() . $fileName;
    }
} 
