<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\RegistrationRequest;

use App\User;

use Auth;
use View;
use Redirect;
use Hash;
use Mail;
use Notifier;

class UserController extends Controller
{

    /* LOGIN */

    /**
     * Render the login view.
     *
     * @return View
     */

    public function getLogin()
    {
        return View::make('home');
    }


    /**
     * Process the login form request.
     *
     * @param LoginUserRequest $request
     *
     * @return Redirect
     */
    public function postLogin( LoginUserRequest $request )
    {
        if (Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')])) {
            Notifier::success( 'Login successfull!' )->flash()->create();
            return Redirect::intended('my/dashboard');
        } else {
            Notifier::error( 'Login Failure!' )->flash()->create();
            return Redirect::back();
        }
    }

    /* LOGOUT */

    /**
     * Process the logout request.
     *
     * @return Redirect
     */
    public function postLogout()
    {
        Auth::logout();
        Notifier::success( 'Logout successfull!' )->flash()->create();
        return Redirect::route('home');
    }


    /* REGISTER */

    /**
     * Render the register view.
     *
     * @return View
     */
    public function getRegister()
    {
        return View::make('register');
    }

    /**
     * Process the register form request.
     *
     * @param RegistrationRequest $request
     *
     * @return Redirect
     */
    public function postRegister( RegistrationRequest $request )
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
        Notifier::success( 'Your account request has been sent.' )->flash()->create();
        return Redirect::route('home');
    }

    /* PROFILE */

    /**
     * Render the profile view.
     *
     * @return View
     */
    public function getProfile() {
        return View::make('profile');
    }

    /**
     * Process the profile form request.
     *
     * @param ProfileRequest $request
     *
     * @return Redirect
     */
    public function postProfile( ProfileRequest $request )
    {
        $data['real_name'] = $request->get( 'real_name' );
        $data['email'] = $request->get( 'email' );
        $data['password'] = $request->get( 'new_password' );

        $user = User::find( Auth::user()->id );
        $user->real_name = $data['real_name'];
        $user->email = $data['email'];
        if( strlen($data['password']) > 0 ) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();

        Notifier::success( 'Profile updated successfully!' )->flash()->create();
        return Redirect::route('home');
    }



}
