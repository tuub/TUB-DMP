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
        return $this->belongsTo('App\DataSource');
    }
}
