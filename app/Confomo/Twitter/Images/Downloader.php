<?php  namespace Confomo\Twitter\Images; 

use Confomo\Entities\TwitterProfile;
use Illuminate\Foundation\Application;

/**
 * Class Downloader
 *
 * Download Twitter images
 *
 * @package Confomo\Twitter\Images
 */
class Downloader
{
    /**
     * @var Application
     */
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Download a Twitter Profile's profile picture locally
     *
     * @param TwitterProfile $profile
     */
    public function cacheProfilePic(TwitterProfile $profile)
    {
        $path_prefix = $this->app->runningInConsole() ? base_path() . '/public/' : '';

        copy(
            $profile->profile_image_url,
            $path_prefix . ltrim($profile->getProfilePictureCachePath(), '/') . md5($profile->id) . '.jpeg'
        );
    }
} 
