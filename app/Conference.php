<?php

namespace App;

use App\Events\FriendWasAdded;
use Illuminate\Database\Eloquent\Model;

class Conference extends Model
{
    protected $fillable = ['name'];
    protected $casts = ['user_id' => 'integer'];

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
}
