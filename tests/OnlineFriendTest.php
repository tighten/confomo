<?php

use App\Conference;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class OnlineFriendTest extends TestCase
{
    use DatabaseMigrations;

    public function test_it_doesnt_show_online_friends_for_another_users_conference()
    {
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $conference1 = factory(Conference::class)->make();
        $conference2 = factory(Conference::class)->make();
        $user1->conferences()->save($conference1);
        $user2->conferences()->save($conference2);

        $this->be($user1);

        $this->json('get', '/api/conferences/' . $conference2->slug . '/online-friends');

        $this->seeStatusCode(404);
    }

    public function test_it_shows_online_friends_for_my_conference()
    {
        $user = factory(User::class)->create();
        $conference = factory(Conference::class)->make();
        $user->conferences()->save($conference);
        $conference->planToMeetOnlineFriend('ambassadorawsum');

        $this->be($user);

        $this->json('get', 'api/conferences/' . $conference->slug . '/online-friends');

        $this->seeJson(['username' => 'ambassadorawsum']);
    }

    public function test_it_can_delete_online_friends()
    {
        $user = factory(User::class)->create();
        $conference = factory(Conference::class)->make();
        $user->conferences()->save($conference);
        $friend = $conference->planToMeetOnlineFriend('mattgreen110');

        $this->be($user);

        $this->json('delete', 'api/conferences/' . $conference->slug . '/online-friends/' . $friend->id);

        $this->json('get', 'api/conferences/' . $conference->slug . '/online-friends');

        $this->dontSeeJson(['username' => 'mattgreen110']);
    }
}
