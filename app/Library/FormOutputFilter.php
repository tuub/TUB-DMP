<?php
namespace App\Library;

use App\Plan;
use App\Question;
use App\Answer;
use App\Survey;

class FormOutputFilter implements OutputInterface
{
    protected $survey;
    protected $question;


    public function __construct( Survey $survey, Question $question )
    {
        $this->survey   = $survey;
        $this->question = $question;
    }

    public function render()
    {
        $output = Answer::getAnswerObject($this->survey, $this->question);
        return $output;
    }
}