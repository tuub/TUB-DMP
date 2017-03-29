<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedbackRequest;
use Notifier;
use Illuminate\Support\Facades\Mail;


class DashboardController extends Controller
{
    public function __construct()
    {
        //$this->beforeFilter('auth');
    }

    public function feedback( FeedbackRequest $request )
    {
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

        //Notifier::success( 'Your Feedback has been sent.' )->flash()->create();

        if ($request->ajax()) {
            if (Mail::failures()) {
                return response()->json([
                    'response' => 500,
                    'msg' => 'OK'
                ]);
            } else {
                return response()->json([
                    'response' => 200,
                    'msg' => 'OK'
                ]);
            }
        };
    }
}