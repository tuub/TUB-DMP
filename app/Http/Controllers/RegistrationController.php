<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\RegistrationRequest;
use View;
use Mail;
use Redirect;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View::make('register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  RegistrationRequest  $request
     * @return Redirect
     */

    public function store( RegistrationRequest $request )
    {
        $account['project_number'] = $request->get( 'project_number' );
        $account['real_name'] = $request->get( 'real_name' );
        $account['email'] = $request->get( 'email' );
        $account['message'] = $request->get( 'message' );

        Mail::send( [ 'text' => 'emails.register' ], [ 'account' => $account ],
            function ( $message ) use ( $account ) {
                $subject = 'TUB-DMP Account please';
                $message->from( env('SERVER_MAIL_ADDRESS', 'server@localhost'), env('SERVER_NAME', 'TUB-DMP') );
                $message->to( env('ADMIN_MAIL_ADDRESS', 'root@localhost'), env('ADMIN_NAME', 'TUB-DMP Administrator') )->subject( $subject );
                $message->replyTo( $account['email'], $account['real_name'] );
            } );
        //Notifier::success( 'Your account request has been sent.' )->flash()->create();
        return Redirect::route('home');
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
