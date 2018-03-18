<?php
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Library\Traits\Uuids;


/**
 * Class DataSourceMapping
 *
 * @package App
 */
class DataSourceMapping extends Model
{
    use Uuids;

    /*
    |--------------------------------------------------------------------------
    | Model Options
    |--------------------------------------------------------------------------
    */

    protected $table = 'data_source_mappings';
    public $incrementing = false;
    public $timestamps = false;
    protected $casts = [
        'data_source_entity' => 'array',
        'target_content' => 'array'
    ];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Many DataSourceMapping belong to 1 DataSource, n:1
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function datasource()
    {
        return $this->belongsTo(DataSource::class);
    }


    /**
     * 1 DataSourceMapping belongs to some MetadataRegistry, 1:n
     *
     * @todo: Really?
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function metadata_registry()
    {
        return $this->belongsTo(MetadataRegistry::class, 'target_metadata_registry_id', 'id');
    }
}