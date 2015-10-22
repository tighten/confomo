<?php

use App\Conference;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ConferenceTest extends TestCase
{
    use DatabaseMigrations;

    public function test_it_can_add_new_friend()
    {
        $user = factory(User::class)->create();
        $conference = factory(Conference::class)->make();
        $user->conferences()->save($conference);

        $conference->meetNewFriend('adamwathan');

        $this->assertFalse($conference->newFriends->isEmpty());
        $this->assertEquals('adamwathan', $conference->newFriends->first()->username);
    }
}
