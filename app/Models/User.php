<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\DatesTranslator;

class User extends Authenticatable
{
    use Notifiable, DatesTranslator;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'role_id', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /*
        Model relationships
    */
    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }

    public function projects()
    {
        return $this->belongsToMany('App\Models\Project');
    }

    public function profile() {
        return $this->hasOne('App\Models\Profile');
    }
}
