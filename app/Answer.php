<?php

namespace App;

use App\Survey;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection as Collection;
use Illuminate\Database\Eloquent\Model;
use App\Library\HtmlOutputFilter;
use App\Library\FormOutputFilter;
use App\Library\PdfOutputFilter;

use Log;
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
                    $output = new HtmlOutputFilter($answers, $question->content_type);
                    break;
                case 'form':
                    $output = new FormOutputFilter($answers, $question->content_type);
                    break;
                case 'pdf':
                    $output = new PdfOutputFilter($answers, $question->content_type);
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


    public static function saveAll( Survey $survey, $data )
    {
        self::where('survey_id', $survey->id)->delete();

        foreach( $data as $question_id => $answer_value ) {
            if(is_array($answer_value)) {

                $answer_value = array_filter($answer_value, 'strlen');

                //echo 'ARRAY';
                $answer = self::formatForInput(
                    collect($answer_value),
                    Question::find($question_id)->content_type
                );
            } else {
                //echo 'NO ARRAY';
                $answer = $answer_value[0];
            }

            self::create([
                'survey_id'   => $survey->id,
                'question_id' => $question_id,
                'value'       => $answer
            ]);

        }

        return true;
    }


    /**
     * @param EloquentCollection $answers
     * @param ContentType $content_type
     * @return EloquentCollection|Collection
     */
    public static function formatForOutput( EloquentCollection $answers, ContentType $content_type )
    {
        $result = collect([]);
        switch($content_type->identifier) {
            case 'list':
                $result = collect([$answers->implode(',', 'value')]);
                break;
            default:
                $result = $answers;
        }

        return $result;
    }


    /**
     * @param Collection $answers
     * @param ContentType $content_type
     * @return array|Collection
     */
    public static function formatForInput( Collection $answers, ContentType $content_type )
    {
        $result = collect([]);
        switch($content_type->identifier) {
            case 'list':
                $result = explode(',', $answers->first());
                break;
            default:
                $result = $answers;
        }

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