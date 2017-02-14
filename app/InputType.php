<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\InputType
 *
 * @property integer $id
 * @property string $name
 * @property string $method
 * @property string $category
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\InputType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\InputType whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\InputType whereMethod($value)
 * @method static \Illuminate\Database\Query\Builder|\App\InputType whereCategory($value)
 * @method static \Illuminate\Database\Query\Builder|\App\InputType whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\InputType whereUpdatedAt($value)
 */
class InputType extends Model
{
    /*
	|--------------------------------------------------------------------------
	| Model Options
	|--------------------------------------------------------------------------
	*/

    protected $table = 'input_types';
    public $timestamps = true;

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

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
