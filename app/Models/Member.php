<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property mixed $name
 * @property mixed $username
 * @property mixed $email
 * @property mixed $phone
 * @property mixed $address
 * @property mixed $gender
 * @property mixed|string $password
 * @property mixed $status
 * @property mixed $birthday
 */
class Member extends Authenticatable implements CanResetPasswordContract
{
    use HasFactory;
    use HasApiTokens;
    use Notifiable;
    use CanResetPassword;
    use Filterable;

    public static function saveModel(self $model, Request $request)
    {
        DB::beginTransaction();
        try {
            $model->name = $request->input('name');
            $model->username = $request->input('username');
            $model->email = $request->input('email');
            $model->phone = $request->input('phone');
            $model->address = $request->input('address');
            $model->gender = $request->input('gender', 1);
            if ($request->input('password')) {
                $model->password = bcrypt($request->input('password'));
            }
            $model->status = $request->boolean('status');
            $model->save();
            DB::commit();
            return $model;
        } catch (\Exception $exception) {
            DB::rollback();
            return $exception;
        }
    }

}
