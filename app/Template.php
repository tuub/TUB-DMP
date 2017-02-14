<?php

namespace App;

    //use Illuminate\Database\Eloquent\Model;

/**
 * App\Template
 *
 * @property integer $id
 * @property string $name
 * @property integer $institution_id
 * @property boolean $is_active
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Plan[] $plans
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Section[] $sections
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Question[] $questions
 * @property-read \App\Institution $institution
 * @method static \Illuminate\Database\Query\Builder|\App\Template whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Template whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Template whereInstitutionId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Template whereIsActive($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Template whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Template whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Template active()
 */
class Template extends \Eloquent
{
    /*
	|--------------------------------------------------------------------------
	| Model Options
	|--------------------------------------------------------------------------
	*/

    protected $table = 'templates';
    public $timestamps = true;
    protected $guarded = [];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    public function plans()
    {
        return $this->hasMany('App\Plan');
    }

    public function sections()
    {
        return $this->hasMany('App\Section');
    }

    public function questions()
    {
        return $this->hasMany('App\Question');
    }

    public function institution()
    {
        return $this->belongsTo('App\Institution');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /*
    |--------------------------------------------------------------------------
    | Model Methods
    |--------------------------------------------------------------------------
    */

}
