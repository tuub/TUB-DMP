<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Library\Traits\Uuids;

class InputType extends Model
{
    use Uuids;

    /*
	|--------------------------------------------------------------------------
	| Model Options
	|--------------------------------------------------------------------------
	*/

    protected $table = 'input_types';
    public $incrementing = false;
    public $timestamps = false;

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    public function content_type()
    {
        $this->belongsToMany(ContentType::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Model Methods
    |--------------------------------------------------------------------------
    */

    public static function getCategory( $input_type_method )
    {
        return self::where('identifier', $input_type_method)->pluck('category');
    }
}
