<?php
namespace App\Library;

use App\Plan;
use App\Question;
use App\Answer;

class PdfOutputFilter implements OutputInterface
{
    protected $plan;
    protected $question;


    public function __construct( Plan $plan, Question $question )
    {
        $this->plan = $plan;
        $this->question = $question;
    }

    public function render()
    {
        $output = null;
        $answers = Answer::getAnswerObject($this->plan, $this->question);
        if( count($answers) > 0 ) {
            $answer_type = $this->question->input_type->category;
            switch( $answer_type ) {
                case 'range':
                    $output = $answers->implode('value', ' - ');
                    break;
                case 'list':
                    $output = $answers->implode('value', '<br/>');
                    break;
                default:
                    foreach( $answers as $answer ) {
                        $output .= nl2br( $answer->value );
                    }
                    break;
            }
        }
        return $output;
    }
}