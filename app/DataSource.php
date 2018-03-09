<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Library\Traits\Uuids;

class DataSource extends Model
{
    use Uuids;

    /*
    |--------------------------------------------------------------------------
    | Model Options
    |--------------------------------------------------------------------------
    */

    protected $table = 'data_sources';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['name', 'identifier', 'type', 'description', 'uri'];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    public function projects()
    {
        return $this->hasMany('App\Project');
    }

    public function namespaces()
    {
        return $this->hasMany(DataSourceNamespace::class);
    }

    public function mappings()
    {
        return $this->hasMany(DataSourceMapping::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Model Mutators
    |--------------------------------------------------------------------------
    */

    public function getTypeAttribute($value) {
        return strtoupper($value);
    }


    public static function getByIdentifier($identifier) {
        return self::where('identifier', $identifier)->first();
    }
}