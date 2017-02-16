<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataSourceMapping extends Model
{
    protected $table = 'data_source_mappings';
    public $timestamps = false;

    public function datasource()
    {
        return $this->belongsTo('App\DataSource');
    }
}
