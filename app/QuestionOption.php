<?php
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Library\Traits\Uuids;


/**
 * Class QuestionOption
 *
 * @package App
 */
class QuestionOption extends Model
{
    use Uuids;

    /*
	|--------------------------------------------------------------------------
	| Model Options
	|--------------------------------------------------------------------------
	*/

    protected $table = 'question_options';
    public $incrementing = false;
    public $timestamps = false;

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * 1 QuestionOption belongs to 1 Question, 1:1
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Model Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Queries QuestionOption for existance.
     *
     * @param string $option_id
     * @return bool
     */
    public static function exists($option_id)
    {
        return self::where('id', '=', $option_id)->exists();
    }


    /**
     * What does it do
     *
     * @todo: Documentation
     *
     * @param string $option_id
     * @return string|null
     */
    public static function getOptionText($option_id)
    {
        $option = self::where( 'id', $option_id )->first();
        if ($option) {
            return $option->text;
        }

        return null;
    }


    /**
     * What does it do
     *
     * @todo: Documentation
     *
     * @param $question
     * @return null
     */
    public static function getDefaultValue( $question )
    {
        $default_option = self::where( 'question_id', '=', $question['id'] )->where( 'default', '=', 1 )->first();

        if ($default_option) {
            return $default_option->id;
        }

        return null;
    }

}
