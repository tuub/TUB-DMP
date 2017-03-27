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

    // 1 Project Metadata belongs to 1 Project.
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // 1 Project Metadata belongs to 1 Metadata Field in the Registry.
    public function metadata_registry()
    {
        return $this->belongsTo(MetadataRegistry::class);
    }

    /*
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
    */


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
                $result = $metadata->map(function ($item, $key) {
                    return Carbon::parse($item);
                })->first();
                break;
            case 'list':
                $result = $metadata->implode(',', 'value');
                break;
            case 'organization':
                //$result = collect($metadata->implode(' & ', 'value'));
                $result = $metadata->implode(' & ', 'value');
                break;
            case 'person':
                $result = $metadata->implode(', ', 'value');
                break;
            default:
                $result = $metadata->implode(', ', 'value');
        }

        return $result;
    }



}