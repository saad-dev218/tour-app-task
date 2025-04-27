<?php

namespace App\Helpers;

use Spatie\Permission\Models\Permission;

if (!function_exists('permissions')) {
    function permissions()
    {
        return [
            'Roles and Permissions' => [
                'manage_roles_and_permission' => 'Manage Roles and Permissions',
            ],
            'Admin' => [
                'manage_users' => 'Manage Users',
                'manage_roles_permissions' => 'Manage Roles and Permissions',
                'view_dashboard' => 'View Dashboard',
            ],
            'Tour Planner' => [
                'view_tours' => 'View Tours',
                'create_tour' => 'Create Tour',
                'view_tour_detail' => 'View Tour Detail',
                'edit_tour' => 'Edit  Tour',
                'delete_tour' => 'Delete  Tour',
            ],
        ];
    }
}
if (!function_exists('checkPermissions')) {
    function checkPermissions($permission)
    {
        $permission = Permission::where('name', $permission)->first();
        if ($permission) {
            return true;
        }
        return false;
    }
}
