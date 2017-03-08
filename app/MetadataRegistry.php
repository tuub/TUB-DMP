<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MetadataRegistry extends Model
{
    protected $table = 'metadata_registry';
    public $timestamps = false;

    public function content_type()
    {
        return hasOne(ContentType::class);
    }

    public function datasource_mapping()
    {
        return $this->hasMany(DataSourceMapping::class);
    }

    public function project_metadata()
    {
        //return $this->belongsTo(ProjectMetadata::class, 'metadata_registry_id');
        return $this->hasMany(ProjectMetadata::class);
    }
}