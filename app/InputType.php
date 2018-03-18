<?php
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Library\Traits\Uuids;


/**
 * Class InputType
 *
 * @package App
 */
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

    /**
     * 1 InputType belongs to many ContentType
     *
     * @todo: Really?
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function content_type()
    {
        return $this->belongsToMany(ContentType::class);
    }


    /*
    |--------------------------------------------------------------------------
    | Model Methods
    |--------------------------------------------------------------------------
    */

    /**
     * What does it do
     *
     * @todo: Documentation
     *
     * @param string $input_type_method
     * @return string
     */
    public static function getCategory($input_type_method)
    {
        return self::where('identifier', $input_type_method)->pluck('category');
    }
}
