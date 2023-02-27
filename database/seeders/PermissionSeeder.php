<?php

namespace Database\Seeders;

use App\Models\PermissionGroup;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        /*
         * You may discover that it is best to flush this package's cache before seeding, to avoid cache conflict errors.
         */
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        $data = config('permission_data');
        if (empty($data) || !is_array($data)) return;
        foreach ($data as $slugGroup => $group) {
            $permissionGroup = PermissionGroup::where('slug', $slugGroup)->first();
            if (!$permissionGroup) {
                $permissionGroup = PermissionGroup::create([
                    'name' => $group['title'],
                    'slug' => $slugGroup
                ]);
            }
            foreach ($group['permissions'] as $permissionKey => $permissionTitle) {
                $permission = Permission::where(
                    [
                        'name' => $permissionKey,
                        'guard_name' => 'web',
                    ]
                )->first();
                if (!$permission) {
                    Permission::create([
                        'name' => $permissionKey,
                        'title' => $permissionTitle,
                        'permission_group_id' => $permissionGroup->id,
                        'guard_name' => 'web',
                    ]);
                }
            }

        }

    }
}
