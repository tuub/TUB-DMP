<?php
namespace App\Library;

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
            /* TODO: Cast JSON to Array in Answer Model */
            $answer = json_decode($answer->value, true);
            //var_dump($answer['value']);
            if( is_array($answer['value']) ) {
                foreach ($answer['value'] as $value) {
                    $output->push($value);
                }
            } else {
                $output->push($answer['value']);
            }
        }

        return $output;
    }
}