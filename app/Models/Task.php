<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\DatesTranslator;

class Task extends Model
{
    use DatesTranslator;
    
    public function sprint()
    {
        $this->belongsTo('App\Models\Sprint');
    }
}
