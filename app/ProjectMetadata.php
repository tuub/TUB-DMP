<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class ProjectMetadata extends Model
{
    protected $table = 'project_metadata';
    protected $fillable = ['content'];
    protected $casts = ['content' => 'array'];


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

    public static function findByIdentifier($identifier)
    {
        $foo = self::with('metadata_registry')->whereHas('metadata_registry', function($q) use ($identifier) {
            $q->where('identifier', $identifier);
        })->first();
        if($foo) {
            return $foo->metadata_registry;
        }
        return null;
    }

    public static function formatForOutput( Collection $metadata, ContentType $content_type )
    {
        $result = null;
        switch($content_type->identifier) {
            case 'date':
                $result = collect(Carbon::parse($metadata->implode(',', 'value')));
                break;
            case 'list':
                $result = collect($metadata->implode(',', 'value'));
                break;
            case 'organization':
                $result = collect($metadata->implode(' & ', 'value'));
                break;
            case 'person':
                $result = collect($metadata->implode(' AND ', 'value'));
                break;
            default:
                $result = $metadata;
        }

        return $result;
    }



}