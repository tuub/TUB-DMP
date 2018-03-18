<?php
/**
 * A Sanitizer toolkit for form request data.
 *
 * @author Fabian Fuerste <fabian.fuerste@tu-berlin.de>
 * @date 2018-01-08
 */

declare(strict_types=1);

namespace App\Library;

/**
 * Class Sanitizer
 *
 * @package App\Library
 */
class Sanitizer
{
    private $request;


    /**
     * Sanitizer constructor.
     *
     * @param $request
     */
    public function __construct($request) {
        $this->request = $request;
    }


    /**
     * Sets empty form fields from request to NULL and optionally removes given fields.
     *
     * @param array $fields_to_remove  Optional array with fields to remove from data
     * @return array The filtered data
     */
    public function cleanUp(array $fields_to_remove = null) : array
    {
        // $data = array_filter($this->request->all(), 'strlen');
        $data = $this->request->all();

        array_walk($data, function (&$item) {
            $item = ($item === '') ? null : $item;
        });

        array_forget($data, $fields_to_remove ?? []);

        return $data;
    }
}