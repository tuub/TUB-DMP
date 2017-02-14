<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

/**
 * App\OptionAnswer
 *
 * @property integer $id
 * @property integer $plan_id
 * @property integer $question_id
 * @property integer $user_id
 * @property integer $question_option_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\OptionAnswer whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\OptionAnswer wherePlanId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\OptionAnswer whereQuestionId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\OptionAnswer whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\OptionAnswer whereQuestionOptionId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\OptionAnswer whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\OptionAnswer whereUpdatedAt($value)
 */
class OptionAnswer extends Model
{
    /*
	|--------------------------------------------------------------------------
	| Model Options
	|--------------------------------------------------------------------------
	*/

    protected $table = 'option_answers';
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

    public static function saveAnswer( $plan_id, $user_id, $question_id, Array $answer )
    {
        OptionAnswer::where('plan_id', '=', $plan_id)
            ->where('question_id', '=', $question_id)
            ->where('user_id', '=', $user_id)
            ->delete();

        QuestionAnswerRelation::where('plan_id', '=', $plan_id)
            ->where('user_id', '=', $user_id)
            ->where('question_id', '=', $question_id)
            ->whereNotNull('option_answer_id')
            ->delete();

        if (count($answer) > 0)
        {
            foreach ($answer as $answer_option)
            {
                if ( QuestionOption::exists( $answer_option ) )
                {
                    $record = new OptionAnswer;
                    $record->plan_id = $plan_id;
                    $record->question_id = $question_id;
                    $record->user_id = $user_id;
                    $record->question_option_id = $answer_option;
                    $record->save();

                    $relation = new QuestionAnswerRelation;
                    $relation->plan_id = $plan_id;
                    $relation->question_id = $question_id;
                    $relation->user_id = $user_id;
                    $relation->option_answer_id = $record->id;
                    $relation->save();
                }
            }
            return true;
        }
        else
        {
            return false;
        }
    }
}
