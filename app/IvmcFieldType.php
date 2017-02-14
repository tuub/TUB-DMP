<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\IvmcFieldType
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\IvmcFieldType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IvmcFieldType whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IvmcFieldType whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IvmcFieldType whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IvmcFieldType whereUpdatedAt($value)
 */
class IvmcFieldType extends \Eloquent
{
    /*
	|--------------------------------------------------------------------------
	| Model Options
	|--------------------------------------------------------------------------
	*/

    protected $table = 'ivmc_field_types';
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

    public static function getName($id) {
        $result = IvmcFieldType::where('id', $id)->pluck('name');
        return $result;
    }
}
