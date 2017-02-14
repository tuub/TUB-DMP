<?php
namespace App\Library;

use App\Plan;
use App\Question;
use App\Answer;

class FormOutputFilter implements OutputInterface
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
        $output = Answer::getAnswerObject($this->plan, $this->question);
        return $output;
    }
}