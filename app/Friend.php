<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    protected $fillable = ['username', 'type'];
    protected $casts = [
        'met' => 'boolean'
    ];

    public function markMet()
    {
        $this->met = true;
    }
}
