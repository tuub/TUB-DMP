<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectMetadata extends Model
{
    protected $table = 'project_metadata';

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function metadata_registry()
    {
        return $this->belongsTo(MetadataRegistry::class);
    }
}