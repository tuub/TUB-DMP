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
            if (is_array($answer->value)) {
                foreach ($answer->value as $value) {
                    if (is_array($value)) {
                        foreach($value as $k => $v) {
                            $output->put($k, $v);
                        }
                    } else {
                        $output->push($value);
                    }
                }
            }
        }

        return $output;
    }
}