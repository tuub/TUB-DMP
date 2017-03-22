<?php
namespace App\Library;

use Illuminate\Database\Eloquent\Collection;
use App\Plan;
use App\Question;
use App\Answer;

class HtmlOutputFilter implements OutputInterface
{
    protected $answers;


    public function __construct( Collection $answers )
    {
        $this->answers = $answers;
    }

    public function render()
    {
        $output = ' --- ';
        foreach ($this->answers as $answer) {
            if (is_array($answer->value)) {
                foreach ($answer->value as $value) {
                    if (is_array($value)) {
                        $output = implode(';', $value);
                    } else {
                        //$output->push($value);
                    }
                }
            }
        }

        return $output;

        /*
        $output = '';
        $answers = Answer::getAnswerObject($this->plan, $this->question);
        if( count($answers) > 0 ) {
            $answer_type = $this->question->input_type->category;
            switch( $answer_type ) {
                case 'range':
                    $output .= $answers->implode('value', ' - ');
                    break;
                case 'list':
                    $output .= $answers->implode('value', '<br/>');
                    break;
                default:
                    foreach( $answers as $answer ) {
                        $output .= nl2br( $answer->value );
                    }
                    break;
            }
        } else {
            $output .= ' - ';
        }

        return $output;
        */
    }
}