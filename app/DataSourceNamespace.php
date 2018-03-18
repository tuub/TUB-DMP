<?php
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Library\Traits\Uuids;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;


/**
 * Class DataSourceNamespace
 *
 * @package App
 */
class DataSourceNamespace extends Model
{
    use Uuids;

    protected $table = 'data_source_namespaces';
    public $incrementing = false;
    public $timestamps = false;

    /**
     * 1 DataSourceNamespace belongs to 1 DataSource, 1:1
     *
     * @todo Through-Relation: DataSource hasmany DataSourceMappings through DataSourceNamespaces? See migration file as well.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function datasource()
    {
        return $this->belongsTo(DataSource::class);
    }


    /**
     * Returns live namespaces for external datasource.
     *
     * Debug method.
     * @todo: In order to prevent errors when the external tables change, as happened in the past.
     *
     * @return Collection
     */
    public static function getLiveNamespaces() {
        return DB::connection('odbc')->select('SELECT TABLE_NAME as name FROM ' . env('APP_ODBC_DATABASE') . '.INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = "BASE TABLE"');
    }

}
