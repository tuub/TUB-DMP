<?php

// TODO: CLEANUP!!! GET THOSE EAGER LOADED RELATIONS RUNNING!

namespace App;

use App\Providers\AppServiceProvider;
use Baum\Node;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Collection;
use phpDocumentor\Reflection\Types\Boolean;
use phpDocumentor\Reflection\Types\String_;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class Project extends Node
{
    protected $table = 'projects';
    public $timestamps = true;
    protected $dates = ['created_at', 'updated_at', 'prefilled_at'];
    protected $fillable = ['identifier', 'parent_id', 'user_id', 'data_source_id', 'is_prefilled', 'prefilled_at'];
    protected $guarded = ['id', 'parent_id', 'lft', 'rgt', 'depth'];

    /* Nested Sets */
    protected $parentColumn = 'parent_id';
    protected $leftColumn = 'lft';
    protected $rightColumn = 'rgt';
    protected $depthColumn = 'depth';
    protected $orderColumn = null;
    protected $scoped = [];

    //////////////////////////////////////////////////////////////////////////////
    //
    // Baum makes available two model events to application developers:
    //
    // 1. `moving`: fired *before* the a node movement operation is performed.
    //
    // 2. `moved`: fired *after* a node movement operation has been performed.
    //
    // In the same way as Eloquent's model events, returning false from the
    // `moving` event handler will halt the operation.
    //
    // Please refer the Laravel documentation for further instructions on how
    // to hook your own callbacks/observers into this events:
    // http://laravel.com/docs/5.0/eloquent#model-events

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /**
     * @return mixed
     */
    public function plans()
    {
        return $this->hasMany(Plan::class)->orderBy('updated_at', 'desc');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function data_source()
    {
        return $this->belongsTo(DataSource::class);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function metadata()
    {
        return $this->hasMany(ProjectMetadata::class);
    }


    /**
     * @param $query
     * @param $flag
     *
     * @return mixed
     */
    public function scopeIsPrefilled($query, $flag)
    {
        return $query->where('is_prefilled', $flag);
    }


    /**
     * @param String $attribute
     *
     * @return Collection|null
     */
    public function getMetadata($attribute)
    {
        $data = null;
        $content_type = new ContentType();

        if ($this->metadata->count()) {
            foreach ($this->metadata as $metadata) {
                if ($metadata->metadata_registry->identifier == $attribute) {
                    $data = collect($metadata->content);
                    $content_type = $metadata->metadata_registry->content_type;
                }
            }

            $data = ProjectMetadata::formatForOutput($data, $content_type);
        }
        return $data;
    }


    /**
     * @param String $attribute
     *
     * @return Collection
     */
    public function getMetadataLabel($attribute)
    {
        $data = null;
        if ($this->metadata->count()) {
            foreach ($this->metadata as $metadata) {
                if ($metadata->metadata_registry->identifier == $attribute) {
                    $data = $metadata->metadata_registry->title;
                }
            }
        } else {
            $data = trans('project.metadata.' . $attribute);
        }

        return trans('project.metadata.' . $attribute);
    }


    /**
     * Renders a status string based on begin and end date.
     *
     * @return string
     */
    public function getStatusAttribute()
    {
        if ($this->getMetadata('begin') && $this->getMetadata('begin')->count()) {
            if (Carbon::parse($this->getMetadata('begin')->first()) > (Carbon::now())) {
                $status = 'Not started';
            } else {
                $status = 'Running';
            }

            if ($this->getMetadata('end') && $this->getMetadata('end')->count()) {
                if (Carbon::parse($this->getMetadata('end')->first()) > (Carbon::now())) {
                    $status = 'Running';
                } else {
                    $status = 'Ended';
                }
            }
        } else {
            $status = 'Unknown';
        }

        return $status;
    }


    /**
     * @param String $attribute
     *
     * @return Collection
     */
    public function getMetadataRegistryIdByIdentifier($identifier)
    {
        $data = null;

        /*
        if ($this->metadata->count()) {
            foreach ($this->metadata as $metadata) {
                if ($metadata->metadata_registry->identifier == $identifier) {
                    $data = $metadata->metadata_registry->id;
                }
            }

            \AppHelper::varDump($data);

        } else {
        */
        $data = MetadataRegistry::where([
            'namespace' => 'project',
            'identifier' => $identifier,
        ])->first()['id'];
        //}

        return $data;
    }


    /**
     * @param $data
     * @return bool
     */
    public function saveMetadata($data)
    {
        if ($data) {
            ProjectMetadata::saveAll($this, $data);
            return true;
        } else {
            throw new NotFoundHttpException;
        }
    }


    public function importFromDataSource0()
    {
        if ($this->data_source) {

            $namespaces = $this->data_source->namespaces;

            foreach ($namespaces as $namespace) {
                $mappings = $this->data_source->mappings()
                    ->with('metadata_registry')
                    ->where('data_source_id', $this->data_source->id)
                    ->where('data_source_namespace_id', $namespace->id)
                    ->get();

                $required_fields = [];

                foreach ($mappings as $mapping) {
                    $required_fields[] = $mapping->data_source_entity[0];
                }

                $external_data = collect();

                if (count($required_fields) > 0) {

                    $external_data = DB::table($namespace->name)
                        ->select($required_fields)
                        ->where('Projekt_Nr', '=', $this->identifier)
                        ->get();

                    $required_fields = [];
                }

                $external_data = $external_data->map(function($x){ return (array) $x; })->toArray();

                foreach ($external_data as $external_datum) {

                    //\AppHelper::varDump($external_datum);

                    $i = 0;
                    $new_item = [];

                    foreach ($mappings as $mapping) {
                        $target_content = $mapping->target_content;
                        $content_type = $mapping->metadata_registry->content_type;
                        $required = $content_type->structure;
                        foreach ($target_content as $target_content_key => $target_content_value) {

                            \AppHelper::varDump($content_type->identifier);

                            if ($target_content_value === 'CONTENT') {
                                $target_content[$target_content_key] = $external_datum[$mapping->data_source_entity[0]];
                                \AppHelper::varDump($target_content);

                                $target_content = array_filter($target_content);

                                $new_item[$i] = $target_content;
                                $i++;


                                //\AppHelper::varDump($external_datum[$mapping->data_source_entity[0]]);
                                /*
                                foreach ($external_data as $external_datum) {

                                    $target_content[$target_content_key] = $external_datum[$mapping->data_source_entity[0]];
                                    $target_content = array_filter($target_content);

                                    $new_item[$i] = $target_content;
                                    $i++;
                                }
                                */
                            }
                            //\AppHelper::varDump($target_content);
                        }

                    }
                    echo '-------------';

                }
            }
        }
    }




    public function importFromDataSource()
    {
        if ($this->data_source) {

            $namespaces = $this->data_source->namespaces;

            $metadata_fields = MetadataRegistry::where('namespace', 'project')->get();
            foreach ($metadata_fields as $metadata_field) {
                //\AppHelper::varDump($metadata_field->id . ': ' . $metadata_field->identifier);
                foreach ($namespaces as $namespace) {
                    $mappings = $this->data_source->mappings()
                        ->where('data_source_id', $this->data_source->id)
                        ->where('data_source_namespace_id', $namespace->id)
                        ->where('target_metadata_registry_id', $metadata_field->id)
                        ->get();

                    $i = 0;
                    $new_item = [];

                    foreach($mappings as $mapping) {
                        $external_data = DB::table($namespace->name)
                            ->select($mapping->data_source_entity[0])
                            ->where('Projekt_Nr', '=', $this->identifier)
                            ->get();

                        $external_data = $external_data->map(function($x){ return (array) $x; })->toArray();

                        $target_content = $mapping->target_content;
                        $content_type = $metadata_field->content_type;
                        $required = $content_type->structure;

                        switch ($content_type->identifier) {
                            case 'person':
                                $k = 0;
                                foreach ($external_data as $external_datum) {
                                    foreach ($target_content as $target_content_key => $target_content_value) {
                                        if ($target_content_value === 'CONTENT') {
                                            $new_item[$k][$target_content_key] = $external_datum[$mapping->data_source_entity[0]];
                                        }
                                    }
                                    $k++;
                                }
                                break;
                            default:
                                foreach ($target_content as $target_content_key => $target_content_value) {
                                    if ($target_content_value === 'CONTENT') {
                                        foreach ($external_data as $external_datum) {
                                            $target_content[$target_content_key] = $external_datum[$mapping->data_source_entity[0]];
                                            $target_content = array_filter($target_content);
                                            $new_item[$i] = $target_content;
                                            $i++;
                                        }
                                    }
                                }
                                break;
                        }
                    }

                    foreach ($new_item as $item) {
                        $item = $item + array_diff_key($required, $item);
                        \AppHelper::varDump($item);
                    }

                    if (count($new_item) > 0) {

                        \AppHelper::varDump($new_item);
                        //$it = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($new_item));
                        //$list = iterator_to_array($it,false);
                        //\AppHelper::varDump($list);

                        switch ($content_type->identifier) {
                            case 'person':
                                //$new_item = [call_user_func_array('array_merge', $new_item)];
                                break;
                            case 'organization':
                                $new_item = call_user_func_array('array_merge', $new_item);
                                break;
                            case 'date':
                                $new_item = call_user_func_array('array_merge', $new_item);
                                break;
                            default:
                                $new_item = $new_item;
                                break;
                        }

                        //\AppHelper::varDump(json_encode($new_item));

                        $data = [$metadata_field->identifier => $new_item];

                        //\AppHelper::varDump($data);

                        /*
                        if ($this->saveMetadata($data)) {
                            $notification = [
                                'status' => 200,
                                'message' => 'Data import successfull!',
                                'alert-type' => 'success'
                            ];
                        } else {
                            $notification = [
                                'status' => 500,
                                'message' => 'Data import not successfull!',
                                'alert-type' => 'error'
                            ];
                        }
                        */

                    }

                    echo '---------------';

                }
            }
        }
    }
    public function importFromDataSource2()
    {
        if ($this->data_source) {

            $namespaces = $this->data_source->namespaces;

            foreach ($namespaces as $namespace) {

                $metadata_fields = MetadataRegistry::where('namespace', 'project')->get();

                foreach ($metadata_fields as $metadata_field) {

                    $content_type = $metadata_field->content_type;
                    $required = $content_type->structure;
                    $external_data = collect([]);
                    $mappings = $this->data_source->mappings()
                        ->where('data_source_id', $this->data_source->id)
                        ->where('data_source_namespace_id', $namespace->id)
                        ->where('target_metadata_registry_id', $metadata_field->id)
                        ->get();

                    foreach ($mappings as $mapping) {

                        //\AppHelper::varDump($mapping);

                        $results = DB::table($namespace->name)
                                    ->select($mapping->data_source_entity[0])
                                    ->where('Projekt_Nr', '=', $this->identifier)
                                    ->get();

                        $results = $results->map(function($x){ return (array) $x; })->toArray();

                        //\AppHelper::varDump($results);

                        if (count($results) > 0) {
                            $i = 0;
                            foreach ($results as $result) {
                                $contents[$i] = collect($mapping->target_content);
                                foreach ($contents[$i] as $key => $value) {
                                    if (strlen($value) > 0) {
                                        if ($value === 'CONTENT') {
                                            $contents[$i][$key] = $result[$mapping->data_source_entity[0]];
                                        }
                                    }
                                }
                                $external_data->push($contents[$i]);
                                $i++;
                            }
                        }
                    };

                    /* OK until here */



                    $external_data = $external_data->reject(function ($value, $key) {
                        //\AppHelper::varDump($value);
                        return count($value) == 0;
                    });



                    if ($external_data->count() > 0) {

                        $result = collect([]);

                        switch ($content_type->identifier) {
                            case 'person':
                                \AppHelper::varDump(count($external_data));
                                /*
                                for ($i=0; $i < count($external_data); $i++) {
                                    $this_person[$i] = $required;
                                    \AppHelper::varDump($this_person[$i]);
                                    echo '---------------------';


                                    //foreach ($external_datum as $external_datum_key => $external_datum_value) {
                                    //    if (strlen($external_datum_value) > 0) {
                                    //        $this_person[$external_datum_key] = $external_datum_value;
                                    //    }
                                    //    $result->push($this_person);
                                    //}
                                }
                                */
                                //\AppHelper::varDump($result);
                                break;

                            case 'date':
                                foreach ($external_data as $external_datum) {
                                    $result = $external_datum;
                                }
                                break;

                            case 'organization':
                                foreach ($external_data as $external_datum) {
                                    $result = $external_datum;
                                }
                                break;

                            default:
                                foreach ($external_data as $external_datum) {
                                    $result->push($external_datum);
                                }
                                break;
                        }

                        $data = [$metadata_field->identifier => $result];

                        //\AppHelper::varDump($data);

                        /*
                        if ($this->saveMetadata($data)) {
                            $notification = [
                                'status' => 200,
                                'message' => 'Data import successfull!',
                                'alert-type' => 'success'
                            ];
                        } else {
                            $notification = [
                                'status' => 500,
                                'message' => 'Data import not successfull!',
                                'alert-type' => 'error'
                            ];
                        }
                        */
                    }
                }
            }
        }
    }




































    public function queryRelation($attribute = null, $language = null, $format = 'html')
    {
        /*
        SELECT project_metadata.id, project_metadata.project_id, project_metadata.content, project_metadata.language,
        metadata_registry.namespace, metadata_registry.identifier,
        input_types.name
        FROM project_metadata
        INNER JOIN metadata_registry
        ON project_metadata.metadata_registry_id = metadata_registry.id
        INNER JOIN input_types
        ON metadata_registry.input_type_id = input_types.id;
        */

        $data = collect([]);
        $query = $this->metadata()
            ->join('metadata_registry', 'project_metadata.metadata_registry_id', '=', 'metadata_registry.id')
            ->join('content_types', 'metadata_registry.content_type_id', '=', 'content_types.id')
            ->select(
                'metadata_registry.title as title',
                'project_metadata.content as content',
                //'project_metadata.language as language',
                'content_types.identifier as content_type'
            )
            ->where('metadata_registry.namespace', 'project');

        if( !is_null($attribute) ) {
            $query = $query->where('metadata_registry.identifier', $attribute);
        }

        if( !is_null($language) ) {
            $query = $query->where('project_metadata.language', $language);
        }

        $results = $query->get();

        /* No results? Return empty collection */

        if($results->isEmpty()) {
            return $data;
        }

        foreach( $results as $result ) {
            if(is_array($result->content)) {
                foreach ($result->content as $value) {
                    if (is_array($value)) {
                        foreach($value as $k => $v) {
                            if(is_numeric($k)) {
                                $data->push($v);
                            } else {
                                $data->put($k, $v);
                            }
                            //$data->put($k, $v);
                        }
                    } else {
                        $data->push($value);
                    }
                }
            }
            $content_type = ContentType::where('identifier', $result->content_type)->first();
            return ProjectMetadata::formatForOutput($data, $content_type);

            /*
            if( !empty($result->content) ) {

                switch ($result->content_type) {
                    case 'date':
                        //$data->push(Carbon::parse($result->content));
                        break;
                    case 'person':
                        $data->push($result->content);
                        break;
                    case 'organization':
                        $data->push($result->content);
                        break;
                    default:
                        $data->push($result->content);
                        break;
                };
            };
            */
        }

        /*
        $data = DB::table('project_metadata')
            ->join('metadata_registry', 'project_metadata.metadata_registry_id', '=', 'metadata_registry.id')
            ->pluck('content', 'identifier');
        */
        return $data;
    }



    /*
    public function getTitleAttribute()
    {
        $data = $this->metadata()->with('metadata_registry')->whereHas('metadata_registry', function($q) {
            return $q->where('identifier', '=', 'title');
        })->pluck('content')->implode(' / ');

        return $data;
    }

    public function getBeginDateAttribute()
    {
        $data = $this->metadata()->with('metadata_registry')->whereHas('metadata_registry', function($q) {
            return $q->where('identifier', '=', 'begin');
        })->first()['content'];

        if(!empty($data)) {
            return Carbon::parse($data)->format('Y/m/d');
        }
        return null;
    }

    public function getEndDateAttribute()
    {
        $data = $this->metadata()->with('metadata_registry')->whereHas('metadata_registry', function($q) {
            return $q->where('identifier', '=', 'end');
        })->first()['content'];

        if(!empty($data)) {
            return Carbon::parse($data)->format('Y/m/d');
        }
        return null;
    }

    public function getMembersAttribute()
    {
        $data = $this->metadata()->with('metadata_registry')->whereHas('metadata_registry', function($q) {
            return $q->where('identifier', '=', 'members');
        })->pluck('content');

        return $data;
    }

    public function getFundersAttribute()
    {
        $data = $this->metadata()->with('metadata_registry')->whereHas('metadata_registry', function($q) {
            return $q->where('identifier', '=', 'funding_source');
        })->pluck('content')->implode(', ');

        return $data;
    }


    public function getMetadataViaRelation($attribute = null, $language = null, $format = 'html')
    {
        $data = collect([]);

        $metadata_query = $this->metadata()->whereHas('metadata_registry', function ($q) use($attribute, $language) {
            $q->where('identifier', $attribute);
            if( !is_null($language) ) {
                $q->where('project_metadata.language', $language);
            }
        });
        $results = $metadata_query->get();

        //dd($results);

        if($results->isEmpty()) {
            return $data;
        }

        foreach( $results as $result ) {
            if( !empty($result->content) ) {
                switch ($result->content_type) {
                    case 'date':
                        $content = Carbon::parse($result->content)->format('Y/d/m');
                        $data = $content;
                        break;
                    case 'organization':
                        break;
                    case 'person':
                        $data->push($result->content);
                        break;
                    default:
                        $data->push($result->content);
                        break;
                };
            };
        };
        return $data;
    }

    public function getMetadataViaFoo($attribute = null, $language = null, $format = 'html')
    {
        $data = collect([]);

        $metadata_query = $this->metadata()->whereHas('metadata_registry', function ($q) use($attribute, $language) {
            $q->where('identifier', $attribute);
            if( !is_null($language) ) {
                $q->where('project_metadata.language', $language);
            }
        });
        $results = $metadata_query->get();

        //dd($results);



        //$foobar = collect([]);
        //$foo = $this->with('metadata', 'metadata.metadata_registry')->get();
        //foreach( $this->metadata as $md ) {
        //    $foobar->put($md->metadata_registry->identifier, $md->content['value']);
        //}

return $results;
}



    */
}
