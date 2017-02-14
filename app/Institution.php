<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Institution
 *
 * @property integer $id
 * @property string $name
 * @property string $url
 * @property string $logo
 * @property boolean $is_active
 * @property boolean $is_external
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Template[] $templates
 * @method static \Illuminate\Database\Query\Builder|\App\Institution whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Institution whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Institution whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Institution whereLogo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Institution whereIsActive($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Institution whereIsExternal($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Institution whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Institution whereUpdatedAt($value)
 */
class Institution extends Model
{
    /*
	|--------------------------------------------------------------------------
	| Model Options
	|--------------------------------------------------------------------------
	*/

    protected $table = 'institutions';
    public $timestamps = true;

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    public function templates()
    {
        return $this->hasMany('App\Template');
    }

    public function users()
    {
        return $this->hasMany('App\User');
    }

    /*
    |--------------------------------------------------------------------------
    | Model Methods
    |--------------------------------------------------------------------------
    */

}
