<?php

namespace App;

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
            'met' => true
        ]);

        $this->newFriends()->save($friend);

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
            'type' => 'online'
        ]);

        $this->onlineFriends()->save($friend);

        return $friend;
    }

    public function onlineFriends()
    {
        return $this->hasMany(Friend::class)->where('type', 'online');
    }
}
