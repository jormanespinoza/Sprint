<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\DatesTranslator;
use Carbon\Carbon;

class Sprint extends Model
{
    use DatesTranslator;

    protected $dates = [
        'starts_on',
        'ends_on'
    ];

    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }

    public function tasks()
    {
        return $this->hasMany('App\Models\Task');
    }
}
