<?php

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Conference;
use App\Friend;
use App\Tweeter;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Mockery as m;

class TweeterTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->twitter = m::mock(TwitterOAuth::class)->shouldIgnoreMissing();

        app()->instance(TwitterOAuth::class, $this->twitter);
    }

    /** @test */
    public function friend_passes_tweeter_details()
    {
        $user = factory(User::class)->create();
        $conference = factory(Conference::class)->create(['user_id' => $user->id]);
        $friend = factory(Friend::class)->create(['conference_id' => $conference]);

        $tweeter = factory(Tweeter::class)->create(['username' => $friend->username]);

        $this->assertEquals($tweeter->name, $friend->name);
        $this->assertEquals($tweeter->location, $friend->location);
        $this->assertEquals($tweeter->description, $friend->description);
        $this->assertEquals($tweeter->url, $friend->url);
        $this->assertEquals($tweeter->url_display, $friend->url_display);
    }

    /** @test */
    public function adding_a_friend_adds_new_tweeter_if_doesnt_exist()
    {
        $user = factory(User::class)->create();
        $conference = factory(Conference::class)->create(['user_id' => $user->id]);

        $conference->meetNewFriend('stauffermatt');

        $this->assertEquals(1, Tweeter::count());
    }

    /** @test */
    public function adding_a_friend_doesnt_create_tweeter_if_one_exists()
    {
        $user = factory(User::class)->create();
        $conference = factory(Conference::class)->create(['user_id' => $user->id]);

        $conference->meetNewFriend('stauffermatt');

        $user2 = factory(User::class)->create();
        $conference2 = factory(Conference::class)->create(['user_id' => $user2->id]);

        $conference2->meetNewFriend('stauffermatt');

        $this->assertEquals(1, Tweeter::count());
    }

    /** @test */
    public function fetcher_syncs_friends_data()
    {
        $fromTwitter = (object) [
            'name' => 'Matt Stauffer',
            'location' => 'Gainesville, FL',
            'description' => 'A guy',
            'entities' => [],
            'profile_image_url_https' => 'abcde',
        ];

        $this->twitter->shouldReceive('get')->andReturn($fromTwitter);

        $user = factory(User::class)->create();
        $conference = factory(Conference::class)->create(['user_id' => $user->id]);
        $conference->meetNewFriend('stauffermatt');

        Tweeter::first()->update(['name' => 'Bob', 'updated_at' => Carbon::now()->subYear()]);

        Artisan::call('twitter:fetch-info');

        $this->assertEquals(Carbon::now()->format('Y-m-d'), Tweeter::first()->updated_at->format('Y-m-d'));
    }
}
