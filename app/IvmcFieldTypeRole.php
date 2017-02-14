<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\IvmcFieldTypeRole
 *
 * @property integer $id
 * @property integer $ivmc_field_type_id
 * @property string $name
 * @property integer $order
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\IvmcFieldTypeRole whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IvmcFieldTypeRole whereIvmcFieldTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IvmcFieldTypeRole whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IvmcFieldTypeRole whereOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IvmcFieldTypeRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IvmcFieldTypeRole whereUpdatedAt($value)
 */
class IvmcFieldTypeRole extends \Eloquent
{
    /*
	|--------------------------------------------------------------------------
	| Model Options
	|--------------------------------------------------------------------------
	*/

    protected $table = 'ivmc_field_type_roles';
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

    public static function getName($role_id) {
        $result = IvmcFieldTypeRole::where('id', $role_id)->pluck('name');
        return $result;
    }

}
