<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function users()
    {
        $this->belongsToMany('App\Models\User');
    }

    public function sprints() {
        $this->hasMany('App\Models\Sprint');
    }
}
