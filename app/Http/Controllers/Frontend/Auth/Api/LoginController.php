<?php

namespace App\Http\Controllers\Frontend\Auth\Api;

use App\Enums\CommonStatus;
use App\Models\Member;
use App\Traits\HttpResponses;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController
{
    use AuthenticatesUsers;
    use HttpResponses;

    /*
     * Only enable if use token based authentication
     * Also change in RegisterController as well
     */
    protected bool $useTokenAuthentication = false;

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        //config/auth.php
        return Auth::guard('member');
    }

    /**
     * Validate the user login request.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string|email',
            'password' => 'required|string|min:6',
        ]);
    }

    /**
     * The user has been authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @param mixed $user
     * @return mixed
     */
    protected function authenticated(Request $request, Member $user)
    {
        //
        $user->update([
            'status' => CommonStatus::Active
        ]);

        $plainTextToken = null;
        if ($this->useTokenAuthentication) {
            $plainTextToken = $user->createToken("API")->plainTextToken;
        }

        return $this->success([
            'user' => $user,
            'token' => $plainTextToken
        ]);
    }

    /**
     * The user has logged out of the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        //
        $user = Auth::guard('sanctum')->user();

        if ($this->useTokenAuthentication) {
            $user->currentAccessToken()->delete();
        }
        return $this->success([
        ]);
    }

}
