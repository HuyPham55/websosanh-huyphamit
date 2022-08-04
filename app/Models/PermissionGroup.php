<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class PermissionGroup extends Model
{
    use HasFactory;

    public function permissions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Permission::class, 'permission_group_id')->whereIn('name', $this->getAvailablePermissions());
    }

    private function getAvailablePermissions()
    {
        $availablePermissions = [];
        $dataPermissions = config('permission_data');
        if (is_array($dataPermissions) && !empty($dataPermissions)) {
            foreach ($dataPermissions as $keyGroupPermission => $groupPermission) {
                $availablePermissions[] = array_keys($groupPermission['permissions']);
            }
        }
        return array_unique(call_user_func_array('array_merge', $availablePermissions));
    }
}
