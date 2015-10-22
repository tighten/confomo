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
        $this->json('post', '/api/conferences', ['name' => 'MyCon']);

        $this->json('get', '/api/conferences');

        $this->seeJson(['name' => 'MyCon']);
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

        $this->seeJson(['name' => $conference1->name]);
        $this->seeJson(['name' => $conference2->name]);
    }

    public function test_it_can_delete_a_conference()
    {
        $user = factory(User::class)->create();
        $conference = factory(Conference::class)->make();
        $user->conferences()->save($conference);

        $this->be($user);
        $this->json('delete', '/api/conferences/' . $conference->id);

        $this->json('get', '/api/conferences');
        $this->dontSeeJson(['name' => $conference->name]);
    }

    public function test_it_only_shows_conferences_for_authenticated_user()
    {
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $conference1 = factory(Conference::class)->make();
        $conference2 = factory(Conference::class)->make();
        $user1->conferences()->save($conference1);
        $user2->conferences()->save($conference2);

        $this->be($user1);

        $this->json('get', '/api/conferences');

        $this->dontSeeJson(['name' => $conference2->name]);
    }

    public function test_it_doesnt_allow_users_to_delete_other_users_conferences()
    {
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $conference1 = factory(Conference::class)->make();
        $conference2 = factory(Conference::class)->make();
        $user1->conferences()->save($conference1);
        $user2->conferences()->save($conference2);

        $this->be($user1);

        $this->json('delete', '/api/conferences/' . $conference2->id);

        $this->seeStatusCode(404);
    }
}
