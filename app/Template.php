<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    /*
	|--------------------------------------------------------------------------
	| Model Options
	|--------------------------------------------------------------------------
	*/

    protected $table = 'templates';
    public $timestamps = false;
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
