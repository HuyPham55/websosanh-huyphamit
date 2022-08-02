<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = [
            ['name' => RoleEnum::Admin, 'guard_name' => 'web'],
//            ['name' => RoleEnum::Member, 'guard_name' => 'web'],
        ];

        foreach ($data as $role) {
            Role::firstOrCreate($role);
        }
    }
}
