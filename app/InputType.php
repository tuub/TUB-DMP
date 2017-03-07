<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InputType extends Model
{
    /*
	|--------------------------------------------------------------------------
	| Model Options
	|--------------------------------------------------------------------------
	*/

    protected $table = 'input_types';
    public $timestamps = false;

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    public function metadata_registry()
    {
        $this->belongsToMany(MetadataRegistry::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Model Methods
    |--------------------------------------------------------------------------
    */

    public static function getCategory( $input_type_method )
    {
        return self::where('method', $input_type_method)->pluck('category');
    }
}
