<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Library\Traits\Uuids;

class DataSourceMapping extends Model
{
    use Uuids;

    protected $table = 'data_source_mappings';
    public $incrementing = false;
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
        return $this->belongsTo(MetadataRegistry::class, 'target_metadata_registry_id', 'id');
    }
}
