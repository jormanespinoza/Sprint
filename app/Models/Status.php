<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\DatesTranslator;

class Status extends Model
{
    use DatesTranslator;

    public function tasks()
    {
        return $this->belongsToMany('App\Models\Task');
    }
}
