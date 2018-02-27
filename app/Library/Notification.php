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

    public function __construct($status, $message, $type)
    {
        $this->status = $status;
        $this->message = $message;
        $this->type = $type;
    }


    /**
     * Create Flash session with return values for notification
     *
     * @param $request
     * @return mixed
     */
    public function toSession($request) {
        $request->session()->flash('status', $this->status);
        $request->session()->flash('message', $this->message);
        $request->session()->flash('type', $this->type);
    }


    public function toJson($request) {

        return response()->json([
            'status' => $this->status,
            'message' => $this->message,
            'type' => $this->type
        ]);
    }
}