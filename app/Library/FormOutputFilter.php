<?php
declare(strict_types=1);

namespace App\Library;

use App\ContentType;
use Illuminate\Support\Collection;

/**
 * Class FormOutputFilter
 *
 * @package App\Library
 */
class FormOutputFilter implements OutputInterface
{
    protected $inputs;
    protected $content_type;


    /**
     * FormOutputFilter constructor.
     *
     * @param                  $inputs
     * @param ContentType|null $content_type
     */
    public function __construct(Collection $inputs, ContentType $content_type = null)
    {
        $this->inputs = $inputs;
        $this->content_type = $content_type;
    }


    /**
     * Prepares the given inputs for form usage.
     *
     * @todo: Where does the actual formization happen?
     *
     * @return Collection
     */
    public function render()
    {
        $output = collect([]);
        foreach ($this->inputs as $input) {
            /* TODO: Cast JSON to Array in Answer Model */
            if (\is_array($input->value)) {
                foreach ($input->value as $value) {
                    if (\is_array($value)) {
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