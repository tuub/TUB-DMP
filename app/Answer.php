<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Library\HtmlOutputFilter;
use App\Library\FormOutputFilter;
use App\Library\PdfOutputFilter;

/*
use AnswerInterface;
implements AnswerInterface
*/

class Answer extends Model
{
    protected $table = 'answers';
    public $timestamps = true;
    protected $guarded = [];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /**
     * @param Question $question
     * @param Plan     $plan
     *
     * @return null
     */
    public static function check( Question $question, Survey $plan )
    {
        $result = Answer::where([
            'plan_id' => $plan->id,
            'question_id' => $question->id
        ])->get();

        if ( !$result->isEmpty() ) {
            return $result;
        }
        return null;
    }


    /**
     * @param Plan|null     $plan
     * @param Question|null $question
     * @param string        $format
     *
     * @return array|Collection|string
     */
    public static function getAnswer( Survey $survey = null, Question $question = null, $format = 'html' )
    {
        switch( $format ) {
            case 'html':
                $output = new HtmlOutputFilter($survey, $question);
                break;
            case 'form':
                $output = new FormOutputFilter($survey, $question);
                break;
            case 'pdf':
                $output = new PdfOutputFilter($survey, $question);
                break;
        }
        return $output->render();
    }


    /**
     * @param Plan|null     $plan
     * @param Question|null $question
     *
     * @return array|Collection
     */
    public static function getAnswerObject( Survey $survey = null, Question $question = null )
    {
        $result = new Collection;
        $answers = Answer::check( $question, $survey );
        if( $answers ) {
            foreach( $answers as $answer ) {
                $result->push($answer);
            }
        }
        return $result;
    }


    /**
     *
     */
    public function renderAnswer()
    {
        //$foo = new Foo($this);
        //$foo->render();
    }


    /**
     * @param Plan|null     $plan
     * @param Question|null $question
     * @param User|null     $user
     * @param array         $values
     *
     * @return bool
     */
    public static function setAnswer( Plan $plan = null, Question $question = null, User $user = null, Array $values )
    {
        $values = array_filter($values);

        if( !empty($values) ) {
            if($question->input_type->method == 'list') {
                $values = explode( ',', trim($values[0]) );
            }

            /* first delete the existing answer(s) for this specific question ID */
            Answer::where([
                'plan_id' => $plan->id,
                'question_id' => $question->id,
                'user_id' => $plan->user_id
            ])->delete();

            /* then insert the new answer(s) for this specific question ID */
            foreach ( $values as $value ) {
                $a = new Answer([
                    'plan_id' => $plan->id,
                    'question_id' => $question->id,
                    'user_id' => $plan->user_id,
                    'value' => $value
                ]);
                $a->save();
            }
            return true;
        }
        return false;
    }


    /**
     * @param $plan
     *
     * @return bool
     */
    public function copyToPlan( $plan )
    {
        $answer = Answer::find($this->id)->replicate();
        $answer->plan_id = $plan->id;
        $answer->save();
        return true;
    }
}