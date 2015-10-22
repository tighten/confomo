<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conference extends Model
{
    public function meetNewFriend($username)
    {
        $friend = new Friend([
            'username' => $username,
            'type' => 'new'
        ]);

        $this->newFriends()->save($friend);
    }

    public function newFriends()
    {
        return $this->hasMany(Friend::class)->where('type', 'new');
    }

    public function meetOnlineFriend($username)
    {
        $friend = new Friend([
            'username' => $username,
            'type' => 'online'
        ]);

        $this->onlineFriends()->save($friend);
    }

    public function onlineFriends()
    {
        return $this->hasMany(Friend::class)->where('type', 'online');
    }
}
