<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conference extends Model
{
    protected $fillable = [
        'name',
        'list_is_public',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function friends()
    {
        return $this->hasMany(Friend::class);
    }

    public function newFriends()
    {
        return $this->hasMany(Friend::class)->where('type', 'new');
    }

    public function oldFriends()
    {
        return $this->hasMany(Friend::class)->where('type', 'old');
    }

    public function publicUrl()
    {
        return \URL::to('/users/' . \Auth::user()->username . '/conferences/' . $this->id . '/');
    }
}
