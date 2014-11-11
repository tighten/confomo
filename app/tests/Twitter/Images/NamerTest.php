<?php  namespace tests\Twitter\Images; 

use Confomo\Twitter\Images\Namer;

class NamerTest extends \TestCase
{
    public function test_it_returns_blank_profile_image_for_empty_twitter_result()
    {
        $result = Namer::getProfilePictureByTwitterId(null);

        $this->assertEquals($result, '/assets/img/cache/twitter_profile_pics/blank.jpg');

        $result = Namer::getProfilePictureByTwitterId(0);

        $this->assertEquals($result, '/assets/img/cache/twitter_profile_pics/blank.jpg');

        $result = Namer::getProfilePictureByTwitterId('');

        $this->assertEquals($result, '/assets/img/cache/twitter_profile_pics/blank.jpg');
    }

    public function test_it_returns_correct_md5_hash_for_real_twitter_result()
    {
        $result = Namer::getProfilePictureByTwitterId(5);

        $this->assertEquals($result, '/assets/img/cache/twitter_profile_pics/e4da3b7fbbce2345d7772b0674a318d5.jpeg');
    }
}
