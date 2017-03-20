<?php
namespace App\Library;

use App\Question;
use App\Answer;
use App\Survey;
use Illuminate\Database\Eloquent\Collection;


class FormOutputFilter implements OutputInterface
{
    protected $answers;


    public function __construct( Collection $answers )
    {
        $this->answers = $answers;
    }


    public function render()
    {
        $output = new Collection;
        foreach ($this->answers as $answer) {
            $foo = json_decode($answer->value, true);
            foreach($foo as $bar) {
                $output->push($bar);
            }
        }
        return $output;
    }
}