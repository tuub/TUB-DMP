<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Library\Traits\Uuids;

class DataSource extends Model
{
    use Uuids;

    protected $table = 'data_sources';
    public $incrementing = false;
    public $timestamps = false;

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

    public function getIdentifierAttribute($value)
    {
        return strtoupper($value);
    }

    public function getTypeAttribute($value)
    {
        return strtoupper($value);
    }
}