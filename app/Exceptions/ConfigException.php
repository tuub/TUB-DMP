<?php

namespace App\Exceptions;

use Exception;

class ConfigException extends Exception
{
    public $message;

    /**
     * Constructor.
     *
     * @param string $message
     * @return void
     */
    public function __construct($message)
    {
        parent::__construct();
        $this->message = $message;
    }


    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
        \Log::error('CONFIG ERROR :: ' . $this->getFile() . ', line ' . $this->getLine());
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @return \Illuminate\Http\Response
     */
    public function render()
    {
        return view('errors.config', $this);
    }
}
