<?php
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Library\Traits\Uuids;


/**
 * Class MetadataRegistry
 *
 * @package App
 */
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

    /**
     * 1 Metadata Registry item belongs to 1 ContentType, 1:1
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function content_type()
    {
        return $this->belongsTo(ContentType::class);
    }


    /**
     * 1 Metadata Registry item has many DataSourceMapping, 1:n
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function datasource_mapping()
    {
        return $this->hasMany(DataSourceMapping::class);
    }


    /**
     * 1 Metadata Registry item has many ProjectMetadata items, 1:n
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
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

    /**
     * Returns field list
     *
     * @deprecated
     *
     * @param string $namespace
     * @return array|null
     */
    public static function getFieldList($namespace)
    {
        if ($namespace) {
            return self::where('namespace', $namespace)->get(['id', 'identifier']);
        }
        return null;
    }
}