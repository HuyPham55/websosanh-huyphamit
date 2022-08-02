<?php

namespace Database\Seeders;

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
            ['name' => 'Admin', 'guard_name' => 'web'],
//            ['name' => 'Member', 'guard_name' => 'web'],
        ];

        foreach ($data as $role) {
            Role::firstOrCreate($role);
        }
    }
}
