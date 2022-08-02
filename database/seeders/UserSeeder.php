<?php

namespace Database\Seeders;

use App\Enums\CommonStatus;
use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = User::where('email', "admin@laravel.com")->first();
        if (!$user) {
            $user = User::create([
                'user_code' => '88888888',
                'name' => 'Admin',
                'email' => "admin@laravel.com",
                'email_verified_at' => now(),
                'password' => bcrypt('12345678'),
                'status' => CommonStatus::Active
            ]);
        }
        //set permission
        $user->assignRole(RoleEnum::Admin);
    }
}
