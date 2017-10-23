<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Library\Traits\Uuids;

class MetadataRegistry extends Model
{
    use Uuids;

    /*
    |--------------------------------------------------------------------------
    | Model Options
    |--------------------------------------------------------------------------
    */

    protected $table = 'metadata_registry';
    public $incrementing = false;
    public $timestamps = false;

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    public function content_type()
    {
        return $this->belongsTo(ContentType::class);
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

    /*
    |--------------------------------------------------------------------------
    | Model Methods
    |--------------------------------------------------------------------------
    */

    public static function getFieldList($namespace)
    {
        if ($namespace) {
            return self::where('namespace', $namespace)->get(['id', 'identifier']);
        }
        return null;
    }
}