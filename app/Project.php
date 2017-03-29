<?php

// TODO: CLEANUP!!! GET THOSE EAGER LOADED RELATIONS RUNNING!

namespace App;

use Baum\Node;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Collection;
use phpDocumentor\Reflection\Types\Boolean;
use phpDocumentor\Reflection\Types\String_;


class Project extends Node
{
    protected $table = 'projects';
    public $timestamps = true;
    protected $dates = ['created_at', 'updated_at', 'prefilled_at'];
    protected $fillable = ['identifier','parent_id','user_id','data_source_id','is_prefilled','prefilled_at'];
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
     * @param $attribute
     *
     * @return Collection
     */
    public function getMetadata($attribute)
    {
        $data = null;

        foreach( $this->metadata as $metadata ) {
            if ($metadata->metadata_registry->identifier == $attribute) {
                $data = $metadata->content;
            }
        }

        return $data;
    }


    /**
     * @param $attribute
     *
     * @return Collection
     */
    public function getMetadataContentType($attribute)
    {
        $data = new ContentType();

        foreach( $this->metadata as $metadata ) {
            if ($metadata->metadata_registry->identifier == $attribute) {
                $data = $metadata->metadata_registry->content_type;
            }
        }

        return $data;
    }


    // TODO: View Composer to the rescue?
    public function getStatusAttribute()
    {
        if( $this->getMetadata('begin')->isEmpty() ) {
            return 'Unknown';
        } else {
            if( $this->getMetadata('end')->isEmpty() || Carbon::parse($this->getMetadata('end')->first()) > (Carbon::now())) {
                return 'Running';
            } else {
                return 'Ended';
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
