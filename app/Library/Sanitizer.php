<?php
/**
 * Created by PhpStorm.
 * User: fab
 * Date: 08.01.18
 * Time: 14:22
 */

namespace App\Library;


class Sanitizer
{
    private $request;

    public function __construct($request) {
        $this->request = $request;
    }

    public function cleanUp() {
        //$data = array_filter($this->request->all(), 'strlen');
        $data = $this->request->all();
        array_walk($data, function (&$item) {
            $item = ($item == '') ? null : $item;
        });

        return $data;
    }
}