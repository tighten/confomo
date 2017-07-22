<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use OwnsModels;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'twitter_id', 'username'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Database fields that should be cast to specific types.
     *
     * @var array
     */
    protected $casts = ['id' => 'int'];

    public function conferences()
    {
        return $this->hasMany(Conference::class);
    }

    public function addConference($conference)
    {
        return $this->conferences()->save(new Conference($conference));
    }
}
