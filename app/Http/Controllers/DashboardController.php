<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\FeedbackRequest;
use App\Library\Notification;
use Illuminate\Support\Facades\Mail;


/**
 * Class DashboardController
 *
 * @package App\Http\Controllers
 */
class DashboardController extends Controller
{
    /**
     * DashboardController constructor.
     */
    public function __construct()
    {
        //$this->beforeFilter('auth');
    }


    /**
     * Processes feedback form.
     * @todo Refactor to mailable.
     *
     * @param FeedbackRequest $request
     * @return \Illuminate\Http\JsonResponse|null
     */
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

            if (Mail::failures()) {
                $notification = new Notification(500, 'Error while sending the feedback!', 'error');
            } else {
                $notification = new Notification(200, 'Successfully sent the feedback!', 'success');
            }

            /* The JSON response */
            return $notification->toJson($request);
        }

        return null;
    }
}