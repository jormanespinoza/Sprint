<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\DatesTranslator;

class Profile extends Model
{
    use DatesTranslator;

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}