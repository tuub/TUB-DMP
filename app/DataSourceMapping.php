<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataSourceMapping extends Model
{
    protected $table = 'data_source_mappings';
    public $timestamps = false;

    public function datasource()
    {
        return $this->belongsTo(DataSource::class);
    }

    public function metadata_field()
    {
        return $this->belongsTo(MetadataRegistry::class);
    }
}
