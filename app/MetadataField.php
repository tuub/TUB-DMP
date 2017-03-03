<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MetadataField extends Model
{
    protected $table = 'metadata_fields';
    public $timestamps = false;

    public function input_type()
    {
        return hasOne(InputType::class);
    }

    public function datasource_mapping()
    {
        return $this->hasMany(DataSourceMapping::class);
    }

    public function project_metadata()
    {
        return $this->hasMany(ProjectMetadata::class);
    }
}