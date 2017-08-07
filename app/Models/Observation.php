<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\DatesTranslator;

class Observation extends Model
{
    use DatesTranslator;

    public function task() {
        return $this->belongsTo('App\Models\Task');
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
