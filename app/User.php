<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, OwnsModels;

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
    protected $fillable = ['name', 'twitter_id', 'twitter_nickname', 'userIsSearchable', 'conferenceListIsPublic', 'avatar'];

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

    /**
     * Fields that should be appended to the model when cast to an array or json.
     * @var array
     */
    protected $appends = ['avatar_url'];

    public function conferences()
    {
        return $this->hasMany(Conference::class);
    }

    public function addConference($conference)
    {
        return $this->conferences()->save(new Conference($conference));
    }

    public function getAvatarAttribute()
    {
        return sprintf('assets/img/cache/twitter_profile_pics/%s', sha1($this->twitter_nickname));
    }

    public function getAvatarUrlAttribute()
    {
        return asset(sprintf('avatar/%s', $this->twitter_nickname));
    }
}
