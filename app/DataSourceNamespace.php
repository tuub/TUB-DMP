<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataSourceNamespace extends Model
{
    protected $table = 'data_source_namespaces';
    public $timestamps = false;

    //TODO: Through-Relation: DataSource hasmany DataSourceMappings through DataSourceNamespaces? See migration file as well.
    public function datasource()
    {
        return $this->belongsTo(DataSource::class);
    }


    /* TODO: TUB only: In order to prevent errors when the external tables change */
    public static function getLiveNamespaces() {
        $result = DB::connection('odbc')->select("SELECT TABLE_NAME as name FROM " . env('APP_ODBC_DATABASE', null) . ".INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE'");
        $result = collect($result);
        var_dump($result);
    }

}
