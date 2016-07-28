<?php

namespace App;

use App\Events\FriendWasAdded;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Conference extends Model
{
    protected $fillable = ['name', 'start_date', 'end_date', 'slug'];
    protected $casts = ['user_id' => 'integer'];
    protected $dates = ['start_date', 'end_date'];

    public function save(array $options = [])
    {
        if ($this->slug === null) {
            return $this->saveWithNewSlug($options);
        }

        return parent::save($options);
    }

    private function saveWithNewSlug(array $options = [])
    {
        return retry(5, function () use ($options) {
            $this->regenerateSlug();

            return parent::save($options);
        });
    }

    private function regenerateSlug()
    {
        $this->slug = str_random(16);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function meetNewFriend($username)
    {
        $friend = new Friend([
            'username' => $this->normalizeFriendName($username),
            'type' => 'new',
            'met' => true,
        ]);

        $this->newFriends()->save($friend);

        event(new FriendWasAdded($friend));

        return $friend;
    }

    public function newFriends()
    {
        return $this->hasMany(Friend::class)->where('type', 'new');
    }

    public function planToMeetOnlineFriend($username)
    {
        $friend = new Friend([
            'username' => $this->normalizeFriendName($username),
            'type' => 'online',
            'met' => false,
        ]);

        $this->onlineFriends()->save($friend);

        event(new FriendWasAdded($friend));

        return $friend;
    }

    public function onlineFriends()
    {
        return $this->hasMany(Friend::class)->where('type', 'online');
    }

    public function makeIntroduction($username)
    {
        $friend = Friend::firstOrNew(['username' => $this->normalizeFriendName($username)]);

        if ($friend->id) {
            $friend->introduction = true;
            $friend->save();

            return $friend;
        }

        $friend->type = $this->isUpcoming() ? 'online' : 'new';
        $friend->introduction = true;
        $friend->met = ! $this->isUpcoming();

        $relationship = $this->isUpcoming() ? 'onlineFriends' : 'newFriends';

        $this->$relationship()->save($friend);

        event(new FriendWasAdded($friend));

        return $friend;
    }

    public function isUpcoming()
    {
        if (is_null($this->start_date)) {
            return false;
        }

        return $this->start_date->gt(Carbon::now());
    }

    public function isInProgress()
    {
        if (is_null($this->start_date) || is_null($this->end_date)) {
            return false;
        }

        return Carbon::now()->between($this->start_date, $this->end_date);
    }

    public function isFinished()
    {
        if (is_null($this->end_date)) {
            return false;
        }

        return $this->end_date->lt(Carbon::now());
    }

    protected function normalizeFriendName($username)
    {
        return str_replace('@', '', $username);
    }
}
