<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Institution;
use View;
use Redirect;
use Hash;
use Session;

use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    protected $user;
    protected $institution;

    public function __construct( User $user, Institution $institution )
    {
        //$this->beforeFilter('auth');
        $this->user = $user;
        $this->institution = $institution;
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->user->find($id);
        return view('admin.user.edit', compact('user'));
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
        $user = $this->user->find($id);
        $user->email = $request->get( 'email' );
        $user->is_active = $request->get( 'is_active' );
        $user->is_admin = $request->get( 'is_admin' );
        $user->save();

        return redirect()->route('admin.dashboard');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = $this->user->find($id);
        $user->update([
            'email' => null,
            'tub_om' => null
        ]);
        //$user->delete();

        Session::flash('message', 'Successfully deleted user!');

        return redirect()->route('admin.dashboard');
    }
}
