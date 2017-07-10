<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    public function user()
    {
        $this->belongsTo('App\Models\User');
    }
}
