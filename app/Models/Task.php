<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public function sprint()
    {
        $this->belongsTo('App\Models\Sprint');
    }
}
