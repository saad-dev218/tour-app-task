<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use function App\Helpers\permissions;
use function App\Helpers\checkPermissions;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = permissions();

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);
        $tourPlannerRole = Role::firstOrCreate(['name' => 'tour-planner']);

        foreach ($permissions as $category => $modulePermissions) {
            foreach ($modulePermissions as $permissionKey => $permissionName) {
                if (!checkPermissions($permissionKey)) {
                    $permission = Permission::create(['name' => $permissionKey]);
                } else {
                    $permission = Permission::where('name', $permissionKey)->first();
                }

                if ($category === 'Tour Planner') {
                    $tourPlannerRole->givePermissionTo($permission);
                }

                if ($category === 'User') {
                    $userRole->givePermissionTo($permission);
                }
            }
        }

        $allPermissions = Permission::all();
        $adminRole->syncPermissions($allPermissions);

        $user = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('123456789'),
                'email_verified_at' => now(),
            ]
        );

        $user->assignRole($adminRole);
    }
}
