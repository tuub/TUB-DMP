<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\QuestionAnswerRelation;
use Auth;

/**
 * App\TextAnswer
 *
 * @property integer $id
 * @property integer $plan_id
 * @property integer $question_id
 * @property integer $user_id
 * @property string $text
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\TextAnswer whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TextAnswer wherePlanId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TextAnswer whereQuestionId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TextAnswer whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TextAnswer whereText($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TextAnswer whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TextAnswer whereUpdatedAt($value)
 */
class TextAnswer extends Model
{
    /*
	|--------------------------------------------------------------------------
	| Model Options
	|--------------------------------------------------------------------------
	*/

    protected $table = 'text_answers';
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
        TextAnswer::where('plan_id', '=', $plan_id)
            ->where('question_id', '=', $question_id)
            ->where('user_id', '=', $user_id)
            ->delete();

        QuestionAnswerRelation::where('plan_id', '=', $plan_id)
            ->where('question_id', '=', $question_id)
            ->where('user_id', '=', $user_id)
            ->whereNotNull('text_answer_id')
            ->delete();

        if (!empty($answer[0]))
        {
            $record = new TextAnswer;
            $record->plan_id = $plan_id;
            $record->question_id = $question_id;
            $record->user_id = $user_id;
            $record->text = $answer[0];
            $record->save();

            $relation = new QuestionAnswerRelation;
            $relation->plan_id = $plan_id;
            $relation->question_id = $question_id;
            $relation->user_id = $user_id;
            $relation->text_answer_id = $record->id;
            $relation->save();

            return true;
        }
        else
        {
            return false;
        }
    }

}
