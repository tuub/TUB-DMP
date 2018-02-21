<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\Institution;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Library\Sanitizer;
use App\Library\Notification;

class UserController extends Controller
{
    protected $user;
    protected $institution;

    public function __construct( User $user, Institution $institution )
    {
        $this->user = $user;
        $this->institution = $institution;
    }


    public function edit($id)
    {
        $user = $this->user->find($id);

        return view('admin.user.edit', compact('user'));
    }


    public function update(UpdateUserRequest $request, $id)
    {
        /* Clean input */
        $dirty = new Sanitizer($request);
        $data = $dirty->cleanUp();

        /* The validation */

        /* Get object */
        $user = $this->user->findOrFail($id);

        /* The operation */
        $op = $user->update($data);

        /* Notification */
        if ($op) {
            $notification = new Notification(200, 'Successfully updated the user!', 'success');
        } else {
            $notification = new Notification(500, 'Error while updating the user!', 'error');
        }
        $notification->toSession($request);

        return redirect()->route('admin.dashboard');
    }


    public function destroy(Request $request, $id)
    {
        /* Get object */
        $user = $this->user->find($id);

        /* The operation */
        $op = $user->update([
            'email' => null,
            'tub_om' => null
        ]);

        /* The notification */
        if ($op) {
            $notification = new Notification(200, 'Successfully deleted the user personal information!', 'success');
        } else {
            $notification = new Notification(500, 'Error while deleting the user personal information!', 'error');
        }
        $notification->toSession($request);

        return redirect()->route('admin.dashboard');
    }
}