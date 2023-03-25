<?php

namespace App\Http\Controllers\Frontend\Auth\Api;

use App\Models\Member;
use App\Traits\HttpResponses;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController
{
    use RegistersUsers;
    use HttpResponses;

    /*
     * Only enable if use token based authentication
     * Also change in LoginController as well
     */
    protected bool $useTokenAuthentication = false;

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:members'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        $user = (new Member())->forceFill([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->save();

        return $user;
    }

    protected function registered(Request $request, Member $user)
    {
        //
        $plainTextToken = null;
        if ($this->useTokenAuthentication) {
            $plainTextToken = $user->createToken("API")->plainTextToken;
        }

        return $this->success([
            'user' => $user,
            'token' => $plainTextToken
        ]);
    }
}
