<?php

use App\Conference;
use App\Friend;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

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
        $this->json('post', '/api/conferences', [
            'name' => 'MyCon',
            'start_date' => '2016-07-26',
            'end_date' => '2016-07-29',
        ]);

        $this->json('get', '/api/conferences');

        $this->seeJson([
            'name' => 'MyCon',
            'start_date' => '2016-07-26 00:00:00',
            'end_date' => '2016-07-29 00:00:00',
        ]);
    }

    public function test_it_can_create_a_conference_with_a_url()
    {
        $user = factory(User::class)->create();

        $this->be($user);
        $this->json('post', '/api/conferences', [
            'name' => 'MySecondCon',
            'conf_url' => 'http://example.com',
            'start_date' => '2016-07-26',
            'end_date' => '2016-07-29',
        ]);

        $this->json('get', '/api/conferences');

        $this->seeJson([
            'name' => 'MySecondCon',
            'conf_url' => 'http://example.com',
            'start_date' => '2016-07-26 00:00:00',
            'end_date' => '2016-07-29 00:00:00',
        ]);
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
        $this->json('delete', '/api/conferences/' . $conference->slug);

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

        $this->json('delete', '/api/conferences/'.$conference2->slug);

        $this->seeStatusCode(404);
    }

    public function test_conference_can_start_and_end_on_same_day()
    {
        $user = factory(User::class)->create();

        $this->be($user);
        $this->json('post', '/api/conferences', [
            'name' => 'MyCon',
            'start_date' => '2016-07-26',
            'end_date' => '2016-07-26',
        ]);

        $this->assertResponseOk();
    }

    public function test_conference_cannot_end_before_it_starts()
    {
        $user = factory(User::class)->create();

        $this->be($user);
        $this->json('post', '/api/conferences', [
            'name' => 'MyCon',
            'start_date' => '2016-07-26',
            'end_date' => '2016-07-01',
        ]);

        $this->assertResponseStatus(422);
    }

    public function test_conference_can_end_after_it_starts()
    {
        $user = factory(User::class)->create();

        $this->be($user);
        $this->json('post', '/api/conferences', [
            'name' => 'MyCon',
            'start_date' => '2016-07-26',
            'end_date' => '2016-07-30',
        ]);

        $this->assertResponseOk();
    }

    public function test_it_identifies_an_upcoming_conference()
    {
        $user = factory(User::class)->create();
        $conference = factory(Conference::class)->create([
            'user_id' => $user->id,
            'start_date' => date('Y-m-d', strtotime('+2 day')),
            'end_date' => date('Y-m-d', strtotime('+2 day')),
        ]);

        $this->assertTrue($conference->isUpcoming());
        $this->assertFalse($conference->isInProgress());
        $this->assertFalse($conference->isFinished());
    }

    public function test_it_identifies_an_in_progress_conference()
    {
        $user = factory(User::class)->create();
        $conference = factory(Conference::class)->create([
            'user_id' => $user->id,
            'start_date' => date('Y-m-d', strtotime('-1 day')),
            'end_date' => date('Y-m-d', strtotime('+1 day')),
        ]);

        $this->assertFalse($conference->isUpcoming());
        $this->assertTrue($conference->isInProgress());
        $this->assertFalse($conference->isFinished());
    }

    public function test_it_identifies_a_finished_conference()
    {
        $user = factory(User::class)->create();
        $conference = factory(Conference::class)->create([
            'user_id' => $user->id,
            'end_date' => date('Y-m-d', strtotime('-1 day')),
        ]);

        $this->assertFalse($conference->isUpcoming());
        $this->assertFalse($conference->isInProgress());
        $this->assertTrue($conference->isFinished());
    }

    public function test_it_introduces_a_new_online_friend()
    {
        $user = factory(User::class)->create();
        $conference = factory(Conference::class)->create([
            'user_id' => $user->id,
            'start_date' => date('Y-m-d', strtotime('+1 day')),
        ]);

        $conference->makeIntroduction('michaeldyrynda');

        $this->seeInDatabase('friends', [
            'conference_id' => $conference->id,
            'username' => 'michaeldyrynda',
            'type' => 'online',
            'met' => false,
            'introduction' => true,
        ]);
    }

    public function test_it_introduces_a_new_met_friend_during_a_conference()
    {
        $user = factory(User::class)->create();
        $conference = factory(Conference::class)->create([
            'user_id' => $user->id,
            'start_date' => date('Y-m-d', strtotime('-1 day')),
            'end_date' => date('Y-m-d', strtotime('+1 day')),
        ]);

        $conference->makeIntroduction('michaeldyrynda');

        $this->seeInDatabase('friends', [
            'conference_id' => $conference->id,
            'username' => 'michaeldyrynda',
            'type' => 'new',
            'met' => true,
            'introduction' => true,
        ]);
    }

    public function test_it_introduces_a_new_met_friend_after_a_conference()
    {
        $user = factory(User::class)->create();
        $conference = factory(Conference::class)->create([
            'user_id' => $user->id,
            'start_date' => date('Y-m-d', strtotime('-2 day')),
            'end_date' => date('Y-m-d', strtotime('-1 day')),
        ]);

        $conference->makeIntroduction('michaeldyrynda');

        $this->seeInDatabase('friends', [
            'conference_id' => $conference->id,
            'username' => 'michaeldyrynda',
            'type' => 'new',
            'met' => true,
            'introduction' => true,
        ]);
    }

    public function test_it_strips_leading_at_symbol_when_adding_new_online_friend()
    {
        $user = factory(User::class)->create();
        $conference = factory(Conference::class)->create(['user_id' => $user->id]);

        $conference->planToMeetOnlineFriend('@mattstauffer');

        $this->seeInDatabase('friends', [
            'conference_id' => $conference->id,
            'username' => 'mattstauffer',
        ]);
    }

    public function test_it_strips_leading_at_symbol_when_adding_new_met_friend()
    {
        $user = factory(User::class)->create();
        $conference = factory(Conference::class)->create(['user_id' => $user->id]);

        $conference->meetNewFriend('@marcusmoore');

        $this->seeInDatabase('friends', [
            'conference_id' => $conference->id,
            'username' => 'marcusmoore',
        ]);
    }

    public function test_it_strips_leading_at_symbol_when_introducing_yourself()
    {
        $user = factory(User::class)->create();
        $conference = factory(Conference::class)->create(['user_id' => $user->id]);

        $conference->makeIntroduction('@michaeldyrynda');

        $this->seeInDatabase('friends', [
            'conference_id' => $conference->id,
            'username' => 'michaeldyrynda',
        ]);
    }

    public function test_it_does_not_duplicate_a_friend_if_they_are_already_on_your_list_and_introducing_themselves()
    {
        $user = factory(User::class)->create();
        $conference = factory(Conference::class)->create(['user_id' => $user->id]);

        $conference->planToMeetOnlineFriend('stauffermatt');
        $conference->makeIntroduction('stauffermatt');

        $this->assertCount(1, Friend::where('username', 'stauffermatt')->where('conference_id', $conference->id)->get());
        $this->seeInDatabase('friends', ['username' => 'stauffermatt', 'conference_id' => $conference->id, 'introduction' => true]);
    }
}
