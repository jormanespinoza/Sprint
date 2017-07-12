<?php
namespace App\Traits;

use Jenssegers\Date\Date;

trait DatesTranslator
{
    // Change dates to spanish
    public function getCreatedAtAttribute($date)
    {
        return new Date($date);
    }

    public function getUpdateddAtAttribute($date)
    {
        return new Date($date);
    }
}