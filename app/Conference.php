<?php

namespace App;

use App\Events\FriendWasAdded;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Conference extends Model
{
    protected $fillable = ['name'];
    protected $casts = ['user_id' => 'integer'];
    protected $dates = ['start_date', 'end_date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function meetNewFriend($username)
    {
        $friend = new Friend([
            'username' => $username,
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
            'username' => $username,
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
        $friend = new Friend([
            'username' => $username,
            'type' => $this->isUpcoming() ? 'online' : 'new',
            'introduction' => true,
            'met' => ! $this->isUpcoming(),
        ]);

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
}
