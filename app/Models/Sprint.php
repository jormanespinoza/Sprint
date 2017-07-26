<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\DatesTranslator;

class Sprint extends Model
{
    use DatesTranslator;
    
    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }

    public function tasks()
    {
        return $this->hasMany('App\Models\Task');
    }
}
