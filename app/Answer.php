<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Library\HtmlOutputFilter;
use App\Library\FormOutputFilter;
use App\Library\PdfOutputFilter;

use App\Survey;

/*
use AnswerInterface;
implements AnswerInterface
*/

class Answer extends Model
{
    protected $table    = 'answers';
    public $timestamps  = true;
    protected $guarded  = [];
    protected $casts    = [
        'value' => 'array',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }


    public static function get( Survey $survey = null, Question $question = null, $format = 'html' )
    {
        $output = null;
        $answers = Answer::check( $survey, $question );

        if ($answers) {
            switch ($format) {
                case 'html':
                    $output = new HtmlOutputFilter($answers);
                    break;
                case 'form':
                    $output = new FormOutputFilter($answers);
                    break;
                case 'pdf':
                    $output = new PdfOutputFilter($answers);
                    break;
            }
        }

        return $output->render();
    }


    public static function check( Survey $survey, Question $question )
    {
        $result = Answer::where([
            'survey_id' => $survey->id,
            'question_id' => $question->id
        ])->get();

        return $result;
    }






























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