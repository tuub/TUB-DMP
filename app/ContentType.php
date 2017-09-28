<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Library\Traits\Uuids;

class ContentType extends Model
{
    use Uuids;

    protected $table = 'content_types';
    public $incrementing = false;
    public $timestamps = false;
    protected $casts = ['structure' => 'array'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function metadata_registry()
    {
        return $this->belongsTo(MetadataRegistry::class);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function input_type()
    {
        return $this->belongsTo(InputType::class);
    }

}
