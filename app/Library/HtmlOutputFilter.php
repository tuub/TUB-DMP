<?php
namespace App\Library;

use App\ContentType;
use App\ProjectMetadata;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection as Collection;
use App\Plan;
use App\Question;
use App\Answer;

class HtmlOutputFilter implements OutputInterface
{
    protected $inputs;
    protected $content_type;


    public function __construct( Collection $inputs, ContentType $content_type )
    {
        $this->inputs = $inputs;
        $this->content_type = $content_type;
    }

    public function render()
    {
        $output = collect([]);

        foreach ($this->inputs as $input) {

            if(is_array($input)) {
                $output->push($input);
            } else {
                $output->push(collect([$input]));
            }

            if($input instanceof Answer) {
                foreach( $input->value as $value ) {
                    switch($this->content_type->identifier) {
                        case 'list':
                            $output = $value->implode(', ', $value);
                            break;
                        default:
                            $output = nl2br($value);
                            break;
                    }
                }
            }


            if($input instanceof Collection || $input instanceof ProjectMetadata) {
                $output = $input;
            }
        }

        return $output;
    }
}