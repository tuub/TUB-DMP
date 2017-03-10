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

    public function scopeOfField($query, $field)
    {
        return $query->where('metadata_registry.identifier', $field);
    }

    public function scopeOfLanguage($query, $language = null)
    {
        if( !is_null($language) ) {
            return $query->where('language', $language);
        }
        return $query;
    }
}