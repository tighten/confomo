<?php

use App\Conference;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    public function test_it_retrieves_settings()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $this->json('get', '/api/settings');
        $this->seeJson([
            'conferenceListIsPublic' => false,
            'userIsSearchable' => false,
        ]);
    }

    public function test_it_updates_settings()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $this->json('post', '/api/settings', [
            'conferenceListIsPublic' => true,
            'userIsSearchable' => true,
        ]);

        $this->json('get', '/api/settings');
        $this->seeJson([
            'conferenceListIsPublic' => true,
            'userIsSearchable' => true,
        ]);
    }

    public function test_it_retrieves_users_conferences()
    {
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create(['twitter_nickname' => '5minutegeekshow', 'conferenceListIsPublic' => true]);
        $this->be($user1);

        $conference = factory(Conference::class)->make();
        $user2->conferences()->save($conference);

        $response = $this->json('get', '/api/users/5minutegeekshow/conferences')->response;
        $this->assertCount(1, $response->getOriginalContent());
    }

    public function test_it_respects_user_settings()
    {
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create(['twitter_nickname' => 'northsouthaudio', 'conferenceListIsPublic' => false]);
        $this->be($user1);

        $conference = factory(Conference::class)->make();
        $user2->conferences()->save($conference);

        $this->json('get', '/api/users/northsouthaudio/conferences');
        $this->seeStatusCode(204);
    }
}
