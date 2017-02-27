<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Notifications\Notifiable;

class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, Notifiable;

    protected $table = 'users';
    protected $fillable = ['real_name', 'email', 'password', 'is_active', 'last_login'];
    protected $hidden = ['password', 'remember_token'];

    public function projects()
    {
        return $this->hasMany('App\Project');
    }

    public function institution()
    {
        return $this->belongsTo('App\Institution');
    }

    public function scopeActive($query)
    {
        $query->where('is_active', 1);
    }

    public function getNameWithEmailAttribute()
    {
        return $this->real_name . " <" . $this->email . '>';
    }


    public function isAdmin()
    {
        return $this->is_admin;
    }
}
