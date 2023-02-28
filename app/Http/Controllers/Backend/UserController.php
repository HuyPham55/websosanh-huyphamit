<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\User\UserAddRequest;
use App\Http\Requests\User\UserEditProfileRequest;
use App\Http\Requests\User\UserEditRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;

class UserController extends BaseController
{
    //
    private $routeList;

    public function __construct()
    {
        parent::__construct();
        $this->routeList = 'users.list';
    }

    public function getList()
    {
        $data = User::orderBy('created_at', 'DESC')->paginate();
        return view('admin.user.list', compact('data'));
    }

    public function getAdd()
    {
        $roles = Role::orderBy('name')->get();
        $data = new User();
        return view('admin.user.add', compact('roles', 'data'));
    }

    public function postAdd(UserAddRequest $request)
    {
        DB::transaction(function () use ($request) {
            $user = new User;
            //Insert data
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = bcrypt($request->input('password'));
            $user->status = $request->input('status');
            $user->save();
            $user->assignRole($request->input('role'));
        });
        return redirect()->route($this->routeList)->with(['status' => 'success', 'flash_message' => trans('label.notification.success')]);
    }

    public function getEdit($id = 0)
    {
        $data = User::findOrFail($id);
        $roles = Role::orderBy('name')->get();
        return view('admin.user.edit', compact('data', 'roles'));
    }

    public function postEdit(UserEditRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $this->__validateUniqueEmailRequest($user, $request);

        if ($id === Auth::id()) {
            return redirect()->back()->with(['status' => 'danger', 'flash_message' => trans('label.something_went_wrong')]);
        }

        //Update data
        if (!empty($request->input('password'))) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->status = $request->input('status');
        $user->save();

        $user->syncRoles($request->input('role'));

        return redirect()->route($this->routeList)->with(['status' => 'success', 'flash_message' => trans('label.notification.success')]);
    }

    //Edit profile
    public function getEditProfile(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $data = Auth::user();
        return view('admin.user.edit_profile', compact('data'));
    }

    public function postEditProfile(UserEditProfileRequest $request): \Illuminate\Http\RedirectResponse
    {
        $user = Auth::guard('web')->user();
        $oldPassword = $request->input('old_password');

        //check password
        if (!Hash::check($oldPassword, $user->password)) {
            return redirect()->back()->with(['status' => 'danger', 'flash_message' => trans('validation.current_password')]);
        }
        $this->__validateUniqueEmailRequest($user, $request);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();
        return redirect()->back()->with(['status' => 'success', 'flash_message' => trans('label.notification.success')]);
    }

    public function delete(Request $request)
    {
        $user = User::findOrFail($request->post('item_id') | 0);
        if ($user->id == Auth::id()) {
            return response()->json([
                'status' => 'error',
                'title' => trans('label.error'),
                'message' => trans('label.something_went_wrong')
            ]);
        }
        $flag = $user->delete();
        if ($flag) {
            return response()->json([
                'status' => 'success',
                'title' => trans('label.deleted'),
                'message' => trans('label.notification.success'),
                'reload' => true
            ]);
        }
        return response()->json([
            'status' => 'error',
            'title' => trans('label.error'),
            'message' => trans('label.something_went_wrong')
        ]);
    }

    /**
     * @throws ValidationException
     */
    private function __validateUniqueEmailRequest($user, $request)
    {
        if ($request->input('email') <> $user->email) {
            $this->validate($request, [
                'email' => 'required|email|unique:users,email',
            ]);
        }
    }

    public function getChangePassword(Request $request)
    {
        return view('admin.user.change_password');
    }

    public function postChangePassword(Request $request): \Illuminate\Http\RedirectResponse
    {
        $user = Auth::guard('web')->user();
        $oldPassword = $request->input('old_password');

        //check password
        if (!Hash::check($oldPassword, $user->password)) {
            return redirect()->back()->with(['status' => 'danger', 'flash_message' => trans('validation.current_password')]);
        }

        if (!empty($request->input('password')) || !empty($request->input('password_confirmation'))) {
            $this->validate($request, [
                'password' => 'required|confirmed|min:6',
                'password_confirmation' => 'required',
            ]);
            $user->password = bcrypt($request->input('password'));
            $user->save();
            return redirect()->back()->with(['status' => 'success', 'flash_message' => trans('label.notification.success')]);
        }
        return redirect()->back()->with(['status' => 'danger', 'flash_message' => trans('label.something_went_wrong')]);
    }

}
