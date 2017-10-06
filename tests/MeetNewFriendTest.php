<?php

use App\Conference;
use App\Friend;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class MeetNewFriendTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    public function test_when_i_meet_a_new_friend_then_that_person_is_listed_in_the_new_friends_list()
    {
        $user = factory(User::class)->create();
        $conference = factory(Conference::class)->make();
        $user->conferences()->save($conference);

        $this->be($user);
        $this->json('post', 'api/conferences/' . $conference->slug . '/new-friends', [
            'username' => 'adamwathan',
        ]);

        $this->json('get', 'api/conferences/' . $conference->slug . '/new-friends');

        $this->seeJson(['username' => 'adamwathan']);
    }

    public function test_when_i_meet_a_new_friend_then_that_person_is_marked_as_met()
    {
        $user = factory(User::class)->create();
        $conference = factory(Conference::class)->make();
        $user->conferences()->save($conference);

        $this->be($user);
        $this->json('post', 'api/conferences/' . $conference->slug . '/new-friends', [
            'username' => 'adamwathan',
        ]);

        $friend = Friend::where('username', 'adamwathan')->first();

        $this->assertTrue($friend->met);
    }
}
