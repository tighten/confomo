<?php

use App\Conference;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class MeetOnlineFriendTest extends TestCase
{
    use DatabaseMigrations;

    public function test_when_i_meet_an_online_friend_then_that_person_is_marked_as_met()
    {
        $user = factory(User::class)->create();
        $conference = factory(Conference::class)->make();
        $user->conferences()->save($conference);

        $this->be($user);
        $this->json('post', 'api/conferences/' . $conference->id . '/online-friends', [
            'username' => 'dead_lugosi'
        ]);

        $this->json('get', 'api/conferences/' . $conference->id . '/online-friends');

        $this->seeJson(['username' => 'dead_lugosi']);
    }
}
