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


    /**
     * Constructor.
     *
     * @param Collection $inputs  A metadatum collection.
     * @param ContentType $content_type  A ContentType object.
     *
     */
    public function __construct($inputs, ContentType $content_type = null)
    {
        $this->inputs = $inputs;
        $this->content_type = $content_type;
    }


    /**
     * Renders a metadatum for output in HTML.
     *
     * First, we convert the values according to their content type. The output collection
     * defaults to no conversion at all. Besides it currently can contain Carbon objects
     * and sub collections.
     *
     * Second, we apply more filters to the output collection. Right now, only nl2br is
     * applied by default.
     *
     * @todo Extend for more content types. And probably divide in two methods.
     *
     * @used-by ProjectMetadata::formatForOutput.
     * @return Collection|null
     */
    public function render()
    {
        $output = collect([]);

        if ($this->content_type !== null && \count($this->inputs) > 0) {

            switch ($this->content_type->identifier) {
                case 'date':
                    $output = $this->inputs->map(function ($input) {
                        return Carbon::parse($input);
                    });
                    break;
                case 'person':
                    foreach ($this->inputs as $person) {
                        $output->push(collect([
                            'firstname' => $person['firstname'],
                            'lastname'  => $person['lastname'],
                            'email'     => $person['email'],
                            'uri'       => $person['uri']
                        ]));
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
                                //\AppHelper::varDump($value);
                                break;
                            case 'person':
                                //var_dump($value);
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

            return $output;
        }
    }
}