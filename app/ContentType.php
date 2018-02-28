<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Library\Traits\Uuids;

class ContentType extends Model
{
    use Uuids;

    /*
    |--------------------------------------------------------------------------
    | Model Options
    |--------------------------------------------------------------------------
    */

    protected $table = 'content_types';
    public $incrementing = false;
    public $timestamps = false;
    protected $casts = ['structure' => 'array'];

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

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


    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }


    /**
     * Determine the default content type for survey questions
     *
     * @return ContentType
     */
    public static function getDefault() {
        $default = self::first();
        if (env('DEFAULT_CONTENT_TYPE')) {
            $default = self::where('identifier', env('DEFAULT_CONTENT_TYPE'))->first();
        }

        return $default;
    }

}
