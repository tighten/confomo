<?php

use App\Conference;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

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

        $this->json('get', '/api/conferences/' . $conference2->id . '/online-friends');

        $this->seeStatusCode(404);
    }
}
