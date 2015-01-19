<?php  namespace Confomo\Twitter\Images; 

use Confomo\Entities\TwitterProfile;
use Illuminate\Filesystem\Filesystem;
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
    /**
     * @var Filesystem
     */
    private $filesystem;

    public function __construct(Application $app, Filesystem $filesystem)
    {
        $this->app = $app;
        $this->filesystem = $filesystem;
    }

    /**
     * Download a Twitter Profile's profile picture locally
     *
     * @param TwitterProfile $profile
     */
    public function cacheProfilePic(TwitterProfile $profile)
    {
        $this->filesystem->copy(
            $profile->profile_image_url,
            $this->getProfilePicLocalPath($profile)
        );
    }

    /**
     * @param TwitterProfile $profile
     * @return string
     */
    public function getProfilePicLocalPath(TwitterProfile $profile)
    {
        $path_prefix = $this->app->runningInConsole() ? base_path() . '/public/' : '';

        return $path_prefix . ltrim($profile->getProfilePictureCachePath(), '/') . md5($profile->id) . '.jpeg';
    }
} 
