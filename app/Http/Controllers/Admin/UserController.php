<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Library\Sanitizer;
use App\Library\Notification;


/**
 * Class UserController
 *
 * @package App\Http\Controllers\Admin
 */
class UserController extends Controller
{
    protected $user;


    /**
     * UserController constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }


    /**
     * Renders the edit form for user with the given ID.
     *
     * @param string $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $user = $this->user->find($id);

        return view('admin.user.edit', compact('user'));
    }


    /**
     * Updates the user with the given ID.
     *
     * @param UpdateUserRequest $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
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


    /**
     * Deletes/Deactivates a user with thje given ID and the given request values.
     *
     * Does not really delete the user since the DMPs should stay in the system.
     * Only email and om are set to null.
     *
     * @param Request $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
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