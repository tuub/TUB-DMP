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


    public function __construct($inputs, ContentType $content_type = null)
    {
        $this->inputs = $inputs;
        $this->content_type = $content_type;
    }

    public function render()
    {
        $output = collect([]);

        if (count($this->inputs) > 0) {

            switch ($this->content_type->identifier) {
                case 'date':
                    $output = $this->inputs->map(function ($input) {
                        return Carbon::parse($input);
                    });
                    break;
                case 'person':
                    foreach ($this->inputs as $person) {
                        $person_data = collect();
                        $person_data->put('firstname', $person['firstname']);
                        $person_data->put('lastname', $person['lastname']);
                        $person_data->put('email', $person['email']);
                        $person_data->put('uri', $person['uri']);
                        $output->push($person_data);
                    }
                    break;
                default:
                    $output = $this->inputs;
                    break;
            }

            foreach ($this->inputs as $input) {
                if ($input instanceof Answer) {
                    foreach ($input->value as $value) {
                        switch ($this->content_type->identifier) {
                            case 'list':
                                //$output = $value->implode(', ', $value);
                                \AppHelper::varDump($value);
                                break;
                            case 'person':
                                var_dump($value);
                                break;
                            default:
                                $output = nl2br($value);
                                break;
                        }
                    }
                }

                /*
                if ($input instanceof Collection || $input instanceof ProjectMetadata) {
                    $output = $this->inputs;
                }
                */
            }

            //\AppHelper::varDump($output);

            return $output;
        }
    }
}