<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\UserEditProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends BaseController
{
    //

    //Edit profile
    public function getEditProfile(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $data = Auth::user();
        return view('admin.user.editProfile', compact('data'));
    }

    public function postEditProfile(UserEditProfileRequest $request): \Illuminate\Http\RedirectResponse
    {
        $user = Auth::guard('web')->user();
        $oldPassword = $request->input('old_password');

        //check password
        if (!Hash::check($oldPassword, $user->password)) {
            return redirect()->back()->with(['status' => 'danger', 'message' => trans('label.old_password_incorrect')]);
        }
        $this->__validateUserEditRequest($user, $request);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();
        return redirect()->back()->with(['status' => 'success', 'message' => trans('label.notification.update_success')]);
    }

    /**
     * @throws ValidationException
     */
    private function __validateUserEditRequest($user, $request)
    {
        if ($request->input('email') <> $user->email) {
            $this->validate($request, [
                'email' => 'required|email|unique:users,email',
            ]);
        }
    }

    public function getChangePassword(Request $request)
    {
        return view('admin.user.changePassword');
    }

    public function postChangePassword(Request $request): \Illuminate\Http\RedirectResponse
    {
        $user = Auth::guard('web')->user();
        $oldPassword = $request->input('old_password');

        //check password
        if (!Hash::check($oldPassword, $user->password)) {
            return redirect()->back()->with(['status' => 'danger', 'message' => trans('label.old_password_incorrect')]);
        }

        if (!empty($request->input('password')) || !empty($request->input('password_confirmation'))) {
            $this->validate($request, [
                'password' => 'required|confirmed|min:6',
                'password_confirmation' => 'required',
            ]);
            $user->password = bcrypt($request->input('password'));
            $user->save();
            return redirect()->back()->with(['status' => 'success', 'message' => trans('label.notification.update_success')]);
        }
        return redirect()->back()->with(['status' => 'danger', 'message' => trans('label.notification.something_went_wrong')]);
    }

}
