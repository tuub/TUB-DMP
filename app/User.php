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
use StudentAffairsUwm\Shibboleth\Entitlement;
use Delatbabel\Elocrypt\Elocrypt;
use App\Library\Traits\Uuids;

class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Uuids, Authenticatable, Authorizable, CanResetPassword, Notifiable;

    /*
    |--------------------------------------------------------------------------
    | Model Options
    |--------------------------------------------------------------------------
    */

    protected $table = 'users';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['tub_om', 'institution_id', 'type', 'email', 'is_admin', 'is_active'];
    protected $dates = ['last_login'];
    //protected $encrypts = ['email'];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function plans()
    {
        return $this->hasManyThrough(Plan::class, Project::class);
    }

    public function institution()
    {
        return $this->belongsTo('App\Institution');
    }

    public function entitlements()
    {
        return $this->belongsToMany(Entitlement::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Model Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        $query->where('is_active', 1);
    }

    /*
    |--------------------------------------------------------------------------
    | Model Mutators
    |--------------------------------------------------------------------------
    */

    public function getNameAttribute()
    {
        return session()->get('name');
    }

    public function getInstitutionIdentifierAttribute()
    {
        return session()->get('institution_identifier');
    }

    /*
    public function getNameWithEmailAttribute()
    {
        return $this->name . " <" . $this->email . '>';
    }
    }
    */

    /*
    |--------------------------------------------------------------------------
    | Model Methods
    |--------------------------------------------------------------------------
    */

    public function isAdmin()
    {
        return $this->is_admin;
    }
}
