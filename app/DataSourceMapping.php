<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataSourceMapping extends Model
{
    protected $table = 'data_source_mappings';
    public $timestamps = false;
    protected $casts = [
        'data_source_entity' => 'array',
        'target_content' => 'array',
    ];

    public function datasource()
    {
        return $this->belongsTo(DataSource::class);
    }

    public function metadata_registry()
    {
        return $this->belongsTo(MetadataRegistry::class);
    }
}
