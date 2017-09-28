<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Library\Traits\Uuids;

class Template extends Model
{
    use Uuids;

    /*
	|--------------------------------------------------------------------------
	| Model Options
	|--------------------------------------------------------------------------
	*/

    protected $table = 'templates';
    public $incrementing = false;
    public $timestamps = false;
    protected $guarded = [];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    public function surveys()
    {
        return $this->hasMany(Survey::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }


    /*
    public function questions()
    {
        return $this->hasManyThrough(Question::class, Section::class);
    }
    */

    public function institution()
    {
        return $this->belongsTo(Institution::class);
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
