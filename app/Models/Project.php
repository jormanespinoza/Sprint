<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function users()
    {
        $this->hasToMany('App\Models\User');
    }

    public function sprints() {
        $this->hasToMany('App\Models\Sprint');
    }
}
