<?php namespace Confomo\Entities;

class Conference extends \Eloquent
{
    protected $fillable = [
        'name',
        'list_is_public',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function friends()
    {
        return $this->hasMany('Confomo\Entities\Friend');
    }

    public function newFriends()
    {
        return $this->hasMany('Confomo\Entities\Friend')->where('type', 'new');
    }

    public function oldFriends()
    {
        return $this->hasMany('Confomo\Entities\Friend')->where('type', 'old');
    }
}
