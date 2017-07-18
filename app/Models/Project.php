<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\DatesTranslator;

class Project extends Model
{
    use DatesTranslator;

    public function users()
    {
        return $this->belongsToMany('App\Models\User');
    }

    public function sprints() 
    {
        return $this->hasMany('App\Models\Sprint');
    }
}