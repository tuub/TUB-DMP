<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

/**
 * App\ListAnswer
 *
 * @property integer $id
 * @property integer $plan_id
 * @property integer $question_id
 * @property integer $user_id
 * @property string $text
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\ListAnswer whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ListAnswer wherePlanId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ListAnswer whereQuestionId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ListAnswer whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ListAnswer whereText($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ListAnswer whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ListAnswer whereUpdatedAt($value)
 */
class ListAnswer extends Model
{
    /*
	|--------------------------------------------------------------------------
	| Model Options
	|--------------------------------------------------------------------------
	*/

    protected $table = 'list_answers';
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

    public static function saveAnswer( $plan_id, $user_id, $question_id, Array $answers )
    {
        if( count( $answers ) > 0 )
        {
            if( !in_array( '', $answers ) )
            {
                ListAnswer::where('plan_id', '=', $plan_id)
                    ->where('question_id', '=', $question_id)
                    ->where('user_id', '=', $user_id)
                    ->delete();

                QuestionAnswerRelation::where('plan_id', '=', $plan_id)
                    ->where('question_id', '=', $question_id)
                    ->where('user_id', '=', $user_id)
                    ->whereNotNull('list_answer_id')
                    ->delete();

                foreach( $answers as $answer )
                {
                    $record = new ListAnswer;
                    $record->plan_id = $plan_id;
                    $record->question_id = $question_id;
                    $record->user_id = $user_id;
                    $record->text = $answer;
                    $record->save();

                    $relation = new QuestionAnswerRelation;
                    $relation->plan_id = $plan_id;
                    $relation->question_id = $question_id;
                    $relation->user_id = $user_id;
                    $relation->list_answer_id = $record->id;
                    $relation->save();
                }
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
    }

}
