<?php

use App\Conference;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PlanToMeetOnlineFriendTest extends TestCase
{
    use DatabaseMigrations;

    public function test_when_i_plan_to_meet_online_friend_they_show_up_in_online_friends_list()
    {
        $user       = factory(User::class)->create();
        $conference = factory(Conference::class)->make();
        $user->conferences()->save($conference);

        $friend = $conference->planToMeetOnlineFriend('dead_lugosi');

        $this->be($user);

        $this->json('get', 'api/conferences/' . $conference->slug . '/online-friends');

        $this->seeJson(['username' => 'dead_lugosi']);
    }
}
