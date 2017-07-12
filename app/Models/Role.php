<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\DatesTranslator;

class Role extends Model
{
    use DatesTranslator;

    public function users()
    {
        return $this->belongsToMany('App\Models\User');
    }
}
