<?php

namespace App;

use App\Library\HtmlOutputFilter;
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


    public static function formatForOutput( $metadata, ContentType $content_type )
    {
        $output = collect([]);

        //if( $content_type->identifier == 'date' ) {
        //    dd($metadata);
        //}
        $output = new HtmlOutputFilter($metadata, $content_type);

        return $output->render();
    }



}