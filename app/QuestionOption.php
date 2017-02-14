<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\QuestionOption
 *
 * @property integer $id
 * @property integer $question_id
 * @property string $text
 * @property string $value
 * @property boolean $default
 * @property integer $parent_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Question $question
 * @method static \Illuminate\Database\Query\Builder|\App\QuestionOption whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\QuestionOption whereQuestionId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\QuestionOption whereText($value)
 * @method static \Illuminate\Database\Query\Builder|\App\QuestionOption whereValue($value)
 * @method static \Illuminate\Database\Query\Builder|\App\QuestionOption whereDefault($value)
 * @method static \Illuminate\Database\Query\Builder|\App\QuestionOption whereParentId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\QuestionOption whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\QuestionOption whereUpdatedAt($value)
 */
class QuestionOption extends Model
{
    /*
	|--------------------------------------------------------------------------
	| Model Options
	|--------------------------------------------------------------------------
	*/

    protected $table = 'question_options';
    public $timestamps = true;

    /*
    |--------------------------------------------------------------------------
    | Model Relationships
    |--------------------------------------------------------------------------
    */

    public function question()
    {
        return $this->belongsTo('App\Question');
    }

    /*
    |--------------------------------------------------------------------------
    | Model Methods
    |--------------------------------------------------------------------------
    */

    public static function exists( $option_id )
    {
        $exists = QuestionOption::where('id', '=', $option_id)->exists();
        return $exists;
    }

    public static function getOptionText( $option_id )
    {
        $option = QuestionOption::where( 'id', '=', $option_id )->first();
        if( $option )
        {
            return $option->text;
        }
        else
        {
            return null;
        }
    }

    public static function getDefaultValue( $question )
    {
        $default_option = QuestionOption::where( 'question_id', '=', $question['id'] )->where( 'default', '=', 1 )->first();

        if( $default_option )
        {
            return $default_option->id;
        }
        else
        {
            return null;
        }
    }

}
