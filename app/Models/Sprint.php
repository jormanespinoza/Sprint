<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sprint extends Model
{
    public function project()
    {
        $this->belongsTo('App\Models\Project');
    }

    public function tasks()
    {
        $this->hastToMany('App\Models\Task');
    }
}
