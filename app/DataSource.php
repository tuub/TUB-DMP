<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataSource extends Model
{
    protected $table = 'data_sources';
    public $timestamps = false;

    public function projects()
    {
        return $this->hasMany('App\Project');
    }

    public function namespaces()
    {
        return $this->hasMany('App\DataSourceNamespace');
    }

    public function mappings()
    {
        return $this->hasMany('App\DataSourceMapping');
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