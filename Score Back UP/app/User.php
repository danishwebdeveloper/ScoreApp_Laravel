<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
        return $this->belongsToMany('App\Role', 'user_roles', 'user_id', 'role_id');
    }

    /*Checking Super Admin User Role*/
    public function isSuperAdmin()
    {
        $role = 'super_admin';
        if($this->roles()->where('role_name', $role)->first())
        {
            return true;
        }

        return false;
    }

    /*Checking Admin User Role*/
    public function isAdmin()
    {
        $role = 'admin';
        if($this->roles()->where('role_name', $role)->first())
        {
            return true;
        }

        return false;
    }

    /*Checking Manager User Role*/
    public function isManager()
    {
        $role = 'manager';
        if($this->roles()->where('role_name', $role)->first())
        {
            return true;
        }

        return false;
    }

    /*Checking Player User Role*/
    public function isPlayer()
    {
        $role = 'player';
        if($this->roles()->where('role_name', $role)->first())
        {
            return true;
        }

        return false;
    }
}
