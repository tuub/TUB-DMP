<?php

namespace App;

//use App\MetadataRegistry;
use Baum\Node;
use Carbon\Carbon;
use DB;

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



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plans()
    {
        return $this->hasMany(Plan::class);
    }

    public function data_source()
    {
        return $this->belongsTo(DataSource::class);
    }

    public function metadata()
    {
        return $this->hasMany(ProjectMetadata::class);
    }

    public function scopeUnprefilled($query)
    {
        return $query->where('is_prefilled', false);
    }

    public function scopePrefilled($query)
    {
        return $query->where('is_prefilled', true);
    }

    public function scopeWithInputType($query)
    {
        return $query->addSelect('metadata_registry.input_type_id as fooooo');
    }

    public function getMetadata($attribute)
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

        $result = $this->metadata()
            ->join('metadata_registry', 'project_metadata.metadata_registry_id', '=', 'metadata_registry.id')
            ->join('input_types', 'metadata_registry.input_type_id', '=', 'input_types.id')
            ->select(
                'project_metadata.id',
                'project_metadata.project_id',
                'project_metadata.content',
                'project_metadata.language',
                'metadata_registry.namespace',
                'metadata_registry.identifier',
                'input_types.name'
            )
            //->getQuery() // Optional: downgrade to non-eloquent builder so we don't build invalid User objects.
            ->get();

        dd($result);

        $data = $this->metadata()->with('metadata_registry')->whereHas('metadata_registry', function($q) use($attribute) {
            return $q->where('identifier', $attribute );
        })->toSql();

        dd($data);



        // TODO: process with type
        //dd($data);

        /*
        $data = DB::table('project_metadata')
            ->join('metadata_registry', 'project_metadata.metadata_registry_id', '=', 'metadata_registry.id')
            ->pluck('content', 'identifier');
        */
        return $data;
    }


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


    // TODO: View Composer to the rescue?
    public function getStatusAttribute()
    {
        if(empty($this->begin_date)) {
            return 'Unknown';
        } else {
            if (Carbon::parse($this->end_date) < Carbon::now()->format('Y/m/d')) {
                return 'Running';
            } else {
                return 'Ended';
            }
        }
    }
}
