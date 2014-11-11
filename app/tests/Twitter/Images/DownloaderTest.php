<?php  namespace tests\Authentication;

use Confomo\Entities\TwitterProfile;
use Confomo\Twitter\Images\Downloader;
use Mockery as M;

class DownloaderTest extends \TestCase
{
    protected $app;

    protected $downloadHelper;

    public function setUp()
    {
        parent::setUp();

        $this->app = M::mock('Illuminate\Foundation\Application');
        $this->app->shouldReceive('runningInConsole')->andReturn(false);

        $this->downloadHelper = new Downloader($this->app, M::mock('Illuminate\Filesystem\Filesystem'));
    }

    public function test_copies_file()
    {
        $id = 12345;

        $profile = new TwitterProfile();
        $profile->id = $id;
        $profile->profile_image_url = 'http://www.google.com';

        $filesystem = M::mock('Illuminate\Filesystem\Filesystem');
        $filesystem->shouldReceive('copy')
            ->with(
                $profile->profile_image_url,
                $this->downloadHelper->getProfilePicLocalPath($profile)
            )
            ->once();

        $downloader = new Downloader($this->app, $filesystem);

        $downloader->cacheProfilePic($profile);
    }

    public function test_generates_path()
    {
        $id = 12345;

        $profile = new TwitterProfile();
        $profile->id = $id;

        $expectedPath = 'assets/img/cache/twitter_profile_pics/827ccb0eea8a706c4c34a16891f84e7b.jpeg';

        $this->assertEquals($expectedPath, $this->downloadHelper->getProfilePicLocalPath($profile));
    }
}
