<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedbackRequest;
use App\Library\Notification;
use Illuminate\Support\Facades\Mail;


class DashboardController extends Controller
{
    public function __construct()
    {
        //$this->beforeFilter('auth');
    }


    // FIXME
    public function feedback( FeedbackRequest $request )
    {
        if ($request->ajax()) {

            $feedback['name'] = $request->get( 'name' );
            $feedback['email'] = $request->get( 'email' );
            $feedback['message'] = $request->get( 'message' );

            Mail::send( [ 'text' => 'emails.feedback' ], [ 'feedback' => $feedback ],
                function ( $message ) use ( $feedback ) {
                    $subject = 'TUB-DMP Feedback';
                    $message->from( env('SERVER_MAIL_ADDRESS', 'server@localhost'), env('SERVER_NAME', 'TUB-DMP') );
                    $message->to( env('ADMIN_MAIL_ADDRESS', 'root@localhost'), env('ADMIN_NAME', 'TUB-DMP Administrator') )->subject( $subject );
                    $message->replyTo( $feedback['email'], $feedback['name'] );
                }
            );

            if (!Mail::failures()) {
                $notification = new Notification(200, 'Successfully sent the feedback!', 'success');
            } else {
                $notification = new Notification(500, 'Error while sending the feedback!', 'error');
            }

            /* The JSON response */
            return $notification->toJson($request);
        }

        return abort(403, 'Direct access is not allowed.');
    }
}