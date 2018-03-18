<?php
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Library\Traits\Uuids;


/**
 * Class DataSource
 *
 * @package App
 */
class DataSource extends Model
{
    use Uuids;

    /*
    |--------------------------------------------------------------------------
    | Model Options
    |--------------------------------------------------------------------------
    */

    protected $table = 'data_sources';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['name', 'identifier', 'type', 'description', 'uri'];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * 1 DataSource for many Project, 1:n
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects()
    {
        return $this->hasMany('App\Project::class');
    }


    /**
     * 1 DataSource has many DataSourceNamespace, 1:n
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function namespaces()
    {
        return $this->hasMany(DataSourceNamespace::class);
    }


    /**
     * 1 DataSource has many DataSourceMapping, 1:n
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mappings()
    {
        return $this->hasMany(DataSourceMapping::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Model Mutators
    |--------------------------------------------------------------------------
    */

    /**
     * Returns type attribute in uppercase form.
     *
     * @param string $value
     * @return string
     */
    public function getTypeAttribute($value) {
        return strtoupper($value);
    }


    /**
     * Queries and returns DataSource by given identifier string.
     *
     * @param string $identifier
     * @return DataSource
     */
    public static function getByIdentifier($identifier) {
        return self::where('identifier', $identifier)->first();
    }
}