<?php

use App\Conference;
use App\Friend;
use App\Jobs\FetchTwitterAvatar;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Bus;

class FriendTest extends TestCase
{
    use DatabaseMigrations;

    public function test_it_can_be_marked_met()
    {
        $user = factory(User::class)->create();
        $conference = factory(Conference::class)->make();
        $user->conferences()->save($conference);

        $friend = factory(Friend::class)->make();
        $conference->onlineFriends()->save($friend);

        $this->assertFalse($friend->met);

        $friend->markMet();

        $pulledFriend = Friend::find($friend->id);

        $this->assertTrue($pulledFriend->met);
    }

    public function test_only_unique_twitter_avatars_are_pulled()
    {
        $this->markTestIncomplete('Cannot run until we upgrade Laravel.');

        Bus::fake();

        factory(Friend::class)->create(['conference_id' => 1, 'username' => 'joeschmoe']);
        factory(Friend::class)->create(['conference_id' => 1, 'username' => 'joeschmoe']);
        factory(Friend::class)->create(['conference_id' => 1, 'username' => 'jillschmoe']);

        Artisan::call('twitter:fetch-avatars', ['sync-all']);

        $dispatched = [];

        Bus::assertDispatched(FetchTwitterAvatar::class, function ($command) use ($dispatched) {
            // should not fire twice for the same username
            if (in_array($command->friend->username, $dispatched)) {
                return false;
            }

            $dispatched[] = $command->friend->username;

            return true;
        });
    }
}
