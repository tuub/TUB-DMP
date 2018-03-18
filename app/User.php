<?php
declare(strict_types=1);

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
use App\Library\Traits\Uuids;


/**
 * Class User
 *
 * @package App
 */
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
    protected $fillable = ['tub_om', 'type', 'email', 'is_admin', 'is_active'];
    protected $dates = ['last_login'];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * 1 User has many Project, 1:n
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }


    /**
     * 1 User has many Plan through Project
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function plans()
    {
        return $this->hasManyThrough(Plan::class, Project::class);
    }


    /**
     * @deprecated
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function entitlements()
    {
        return $this->belongsToMany(Entitlement::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Model Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Scopes active users.
     *
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    /*
    |--------------------------------------------------------------------------
    | Model Mutators
    |--------------------------------------------------------------------------
    */

    /**
     * Returns name attribute from session (Shibboleth).
     *
     * Since we do not save the name, we have to write the name to the session
     * and then retrieve it.
     *
     * @return string
     */
    public function getNameAttribute()
    {
        return session()->get('name');
    }


    /**
     * Returns institution identifier attribute from session (Shibboleth).
     *
     * Since we do not save the institution identifier, we have to write the name to the session
     * and then retrieve it.
     *
     * @return string
     */
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

    /**
     * Checks if user is admin.

     * @return bool
     */
    public function isAdmin()
    {
        return $this->is_admin;
    }
}
