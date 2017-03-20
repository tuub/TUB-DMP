<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContentType extends Model
{
    protected $table = 'content_types';
    public $timestamps = false;


    public function metadata_registry()
    {
        return $this->belongsTo(MetadataRegistry::class);
    }

    public function input_type()
    {
        return $this->belongsTo(InputType::class);
    }

}
