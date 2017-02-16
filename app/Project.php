<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';
    public $timestamps = true;
    protected $dates = ['created_at', 'updated_at', 'prefilled_at'];
    protected $fillable = ['identifier','parent_id','user_id','data_source_id','is_prefilled','prefilled_at'];

    public function parent()
    {
        return $this->belongsTo('App\Project', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('App\Project', 'parent_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function data_source()
    {
        return $this->belongsTo('App\DataSource');
    }

    public function plans()
    {
        return $this->hasMany('App\Plan');
    }

    public function scopeUnprefilled($query)
    {
        return $query->where('is_prefilled', false);
    }

    public function scopePrefilled($query)
    {
        return $query->where('is_prefilled', true);
    }

    // TODO: Fix for standalone projects with no children at all
    public function scopeIsParent($query)
    {
        return $query->where('parent_id', null);
    }
}