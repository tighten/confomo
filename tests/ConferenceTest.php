<?php

use App\Conference;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ConferenceTest extends TestCase
{
    use DatabaseMigrations;

    public function test_it_can_meet_new_friend()
    {
        $user = factory(User::class)->create();
        $conference = factory(Conference::class)->make();
        $user->conferences()->save($conference);

        $conference->meetNewFriend('adamwathan');

        $this->assertFalse($conference->newFriends->isEmpty());
        $this->assertEquals('adamwathan', $conference->newFriends->first()->username);
    }

    public function test_it_can_plan_to_meet_online_friend()
    {
        $user = factory(User::class)->create();
        $conference = factory(Conference::class)->make();
        $user->conferences()->save($conference);

        $conference->planToMeetOnlineFriend('dead_lugosi');

        $this->assertFalse($conference->onlineFriends->isEmpty());
        $this->assertEquals('dead_lugosi', $conference->onlineFriends->first()->username);
    }

    public function test_it_can_create_a_conference()
    {
        $user = factory(User::class)->create();

        $this->be($user);
        $this->json('post', '/api/conferences', ['title' => 'MyCon']);

        $this->json('get', '/api/conferences');

        $this->seeJson(['title' => 'MyCon']);
    }

    public function test_it_can_get_all_conferences()
    {
        $user = factory(User::class)->create();
        $conference1 = factory(Conference::class)->make();
        $conference2 = factory(Conference::class)->make();
        $user->conferences()->save($conference1);
        $user->conferences()->save($conference2);

        $this->be($user);
        $this->json('get', '/api/conferences');

        $this->seeJson(['title' => $conference1->title]);
        $this->seeJson(['title' => $conference2->title]);
    }
}
