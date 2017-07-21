<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    protected $fillable = ['username', 'type', 'met', 'introduction'];
    protected $appends = ['avatar_url', 'name', 'location', 'description', 'url', 'url_display'];
    protected $casts = ['met' => 'boolean', 'introduction' => 'boolean'];

    public function getAvatarAttribute()
    {
        return $this->tweeter->avatar;
    }

    public function getAvatarUrlAttribute()
    {
        return $this->tweeter->avatar_url;
    }

    public function getNameAttribute()
    {
        return $this->tweeter->name;
    }

    public function getLocationAttribute()
    {
        return $this->tweeter->location;
    }

    public function getDescriptionAttribute()
    {
        return $this->tweeter->description;
    }

    public function getUrlAttribute()
    {
        return $this->tweeter->url;
    }

    public function getUrlDisplayAttribute()
    {
        return $this->tweeter->url_display;
    }

    public function markMet()
    {
        return $this->update(['met' => true]);
    }

    public function tweeter()
    {
        return $this->belongsTo(Tweeter::class, 'username', 'username');
    }
}
