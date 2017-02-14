<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;


/**
 * App\RangeAnswer
 *
 * @property integer $id
 * @property integer $plan_id
 * @property integer $question_id
 * @property integer $user_id
 * @property string $alpha
 * @property string $omega
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\RangeAnswer whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RangeAnswer wherePlanId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RangeAnswer whereQuestionId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RangeAnswer whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RangeAnswer whereAlpha($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RangeAnswer whereOmega($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RangeAnswer whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RangeAnswer whereUpdatedAt($value)
 */
class RangeAnswer extends Model
{
    /*
	|--------------------------------------------------------------------------
	| Model Options
	|--------------------------------------------------------------------------
	*/

    protected $table = 'range_answers';
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
        if( count( $answer ) == 2 )
        {
            if ( !in_array( '', $answer ) )
            {
                RangeAnswer::where('plan_id', '=', $plan_id)
                    ->where('question_id', '=', $question_id)
                    ->where('user_id', '=', $user_id)
                    ->delete();

                $record = new RangeAnswer;
                $record->plan_id = $plan_id;
                $record->question_id = $question_id;
                $record->user_id = $user_id;
                $record->alpha = $answer[0];
                $record->omega = $answer[1];
                $record->save();

                QuestionAnswerRelation::where('plan_id', '=', $plan_id)
                    ->where('question_id', '=', $question_id)
                    ->where('user_id', '=', $user_id)
                    ->whereNotNull('range_answer_id')
                    ->delete();

                $relation = new QuestionAnswerRelation;
                $relation->plan_id = $plan_id;
                $relation->question_id = $question_id;
                $relation->user_id = $user_id;
                $relation->range_answer_id = $record->id;
                $relation->save();

                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }

        /*
        $new_question_answer_rel = new QuestionAnswerRelation;
        $new_question_answer_rel->plan_id = $plan->id;
        $new_question_answer_rel->question_id = $question_id;
        $new_question_answer_rel->user_id = Auth::user()->id;
        $new_question_answer_rel->range_answer_id = $new_range_answer->id;
        $new_question_answer_rel->save();
        */
    }




}
