<?php

namespace App;

use Baum\Node;
use Carbon\Carbon;

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

    public function getTitleAttribute()
    {
        $field = MetadataField::where('namespace','project')->where('identifier','title')->first();
        return $this->metadata->where('metadata_field_id', $field->id)->pluck('content')->implode(' / ');
    }

    public function getBeginDateAttribute()
    {
        $field = MetadataField::where('namespace','project')->where('identifier','begin')->first();
        return Carbon::parse($this->metadata->where('metadata_field_id', $field->id)->first()['content'])->format('Y/m/d');
    }

    public function getEndDateAttribute()
    {
        $field = MetadataField::where('namespace','project')->where('identifier','end')->first();
        return Carbon::parse($this->metadata->where('metadata_field_id', $field->id)->first()['content'])->format('Y/m/d');
    }

    public function getMembersAttribute()
    {
        $field = MetadataField::where('namespace','project')->where('identifier','members')->first();
        return $this->metadata->where('metadata_field_id', $field->id)->pluck('content');
    }

    public function getFundersAttribute()
    {
        $field = MetadataField::where('namespace','project')->where('identifier','funding_source')->first();
        return $this->metadata->where('metadata_field_id', $field->id)->pluck('content')->implode(', ');
    }


    // TODO: View Composer to the rescue?
    public function getStatusAttribute()
    {
        if(!isset($this->end_date)) {
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
