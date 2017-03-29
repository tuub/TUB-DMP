<?php
namespace App\Library;

use App\ContentType;
use App\ProjectMetadata;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection as Collection;
use App\Plan;
use App\Question;
use App\Answer;

class HtmlOutputFilter implements OutputInterface
{
    protected $inputs;
    protected $content_type;


    public function __construct( $inputs, ContentType $content_type = null )
    {
        $this->inputs = $inputs;
        $this->content_type = $content_type;
    }

    public function render()
    {
        $output = collect([]);

        if(is_array($this->inputs)) {
            if(count($this->inputs) > 0) {
                foreach($this->inputs as $key => $value) {
                    switch ($this->content_type->identifier) {
                        case 'date':
                            $value = Carbon::parse($value);
                            break;

                        default:
                            $value = $value;
                            break;
                    }
                    $output->put($key, $value);
                }
            }
        }

        if(count($this->inputs) > 0) {
            foreach ($this->inputs as $input) {

                if ($input instanceof Answer) {
                    foreach ($input->value as $value) {
                        switch ($this->content_type->identifier) {
                            case 'list':
                                $output = $value->implode(', ', $value);
                                break;
                            default:
                                $output = nl2br($value);
                                break;
                        }
                    }
                }


                //if($input instanceof Collection || $input instanceof ProjectMetadata) {
                //    $output = $input;
                //}
            }
        }

        return $output;
    }
}