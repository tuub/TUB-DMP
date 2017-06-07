<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\RegistrationRequest;
use Illuminate\Support\Facades\Log;

use App\User;

use Auth;
use View;
use Redirect;
use Hash;
use Mail;

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
        return view('home');
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
        if (auth()->attempt(['email' => $request->get('email'), 'password' => $request->get('password')])) {
            $notification = [
                'status'     => 200,
                'message'    => 'Successfully logged in!',
                'alert-type' => 'success'
            ];

            return redirect()->intended('my/dashboard')->with($notification);
        } else {

            $notification = [
                'status'     => 500,
                'message'    => 'Login Failure!',
                'alert-type' => 'error'
            ];

            return redirect()->back()->with($notification);
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
        auth()->logout();
        $notification = [
            'status'     => 200,
            'message'    => 'Logged out!',
            'alert-type' => 'success'
        ];
        return redirect()->route('home')->with($notification);
    }


    /* REGISTER */

    /**
     * Render the register view.
     *
     * @return View
     */
    public function getRegister()
    {
        return view('register');
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
        $account['name'] = $request->get( 'name' );
        $account['email'] = $request->get( 'email' );
        $account['message'] = $request->get( 'message' );

        Mail::send(['text' => 'emails.register'],['account' => $account],
            function ($message) use ($account) {
                $subject = 'TUB-DMP Account please';
                $message->from( env('SERVER_MAIL_ADDRESS', 'server@localhost'), env('SERVER_NAME', 'TUB-DMP') );
                $message->to( env('ADMIN_MAIL_ADDRESS', 'root@localhost'), env('ADMIN_NAME', 'TUB-DMP Administrator') )->subject( $subject );
                $message->replyTo( $account['email'], $account['name'] );
            } );
        $notification = [
            'status'     => 200,
            'message'    => 'Your account request has been sent!',
            'alert-type' => 'success'
        ];
        return redirect()->route('home')->with($notification);
    }

    /* PROFILE */

    /**
     * Render the profile view.
     *
     * @return View
     */
    public function getProfile() {
        return view('profile');
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
        $data['name'] = $request->get( 'name' );
        $data['email'] = $request->get( 'email' );
        $data['password'] = $request->get( 'new_password' );

        $user = auth()->user();
        $user->name = $data['name'];
        $user->email = $data['email'];

        if (strlen($data['password']) > 0) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        $notification = [
            'status'     => 200,
            'message'    => 'Profile updated successfully!',
            'alert-type' => 'success'
        ];

        return redirect()->route('home')->with($notification);
    }



}
