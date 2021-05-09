<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Str;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
            'admin' => [
                'Create User',
                'Read User',
                'User Profile',
                'Update User',
                'Delete User',
                'Create Role',
                'Read Role',
                'Update Role',
                'Delete Role',
                'Create Permission',
                'Read Permission',
                'Update Permission',
                'Delete Permission',
                'Create Post',
                'Read Post',
                'Update Post',
                'Delete Post',
            ],
            'normal-user' => [
                'User Profile',
                'Update User',
                'Create Post',
                'Read Post',
                'Update Post',
                'Delete Post',
            ]
        ];

        foreach ($rows as $role_name => $permissions) {
            $role = Role::updateOrCreate(
                ['name' => $role_name],
                ['display_name' => Str::title(str_replace('-', ' ', $role_name)), 'description' => Str::title(str_replace('-', ' ', $role_name))]
            );

            foreach ($permissions as $permission) {
                $role_permission = Permission::updateOrCreate(
                    ['name' => Str::slug($permission)],
                    ['display_name' => Str::title($permission), 'description' => Str::title($permission)]
                );

                $role->givePermissionTo($role_permission);
            }
        }

    }
}
