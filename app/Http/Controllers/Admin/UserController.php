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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->user->withCount('plans')->get();
        return View::make('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new $this->user;
        $institutions = $this->institution->all()->pluck('name', 'id');
        return View::make('admin.user.new', compact('user','institutions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User;
        $user->name       = $request->get('name');
        $user->email      = $request->get('email');
        $user->institution_id = $request->get('institution_id');
        $user->is_admin = $request->get('is_admin');
        $user->is_active      = $request->get('is_active');
        $user->password      = Hash::make($request->get('new_password'));
        $user->save();
        Session::flash('message', 'Successfully created the user!');
        return Redirect::route('admin.user.index');
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
        $user = $this->user->find($id);
        $institutions = $this->institution->all()->pluck('name', 'id');
        return View::make('admin.user.edit', compact('user','institutions'));
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
        $data = $request->except('_token');
        array_walk($data, function (&$item) {
            $item = ($item == '') ? null : $item;
        });
        $user->update( $data );
        return Redirect::route('admin.user.index');
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
        $user->delete();
        Session::flash('message', 'Successfully deleted user!');
        return Redirect::route('admin.user.index');
    }
}
