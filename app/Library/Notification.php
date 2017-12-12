<?php
/**
 * TITLE
 *
 * DESCRIPTION
 *
 * @author  Fab Fuerste <fab.fuerste@gmail.com>
 * @version 1.0
 * @date    : 07.01.18
 */

namespace App\Library;


class Notification
{
    public $status;
    public $message;
    public $type;
    public $notification;

    public function __construct($status, $message, $type)
    {
        $this->status = $status;
        $this->message = $message;
        $this->type = $type;
    }


    /**
     * Create Flash session with return values for notification
     *
     * @return mixed
     */
    public function toSession($request) {
        $request->session()->flash('message', $this->notification['message']);
        $request->session()->flash('alert-type', $this->notification['alert-type']);
    }
}