<?php

namespace Database\Seeders;

use App\Models\Permissions\Permission;
use App\Models\Roles\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

/**
 * NOTE: If delete permission, make sure delete also at `syncRolesPermissions` method
 */
class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createRoleIfNotExist();
        $this->createAndDeletePermission();
        $this->syncRolesPermissions();
    }

    private function createRoleIfNotExist()
    {
        $roles = collect([
            [
                'name' => 'superadmin',
                'display_name' => 'Superadmin',
                'description' => 'Control and monitor all system functionality',
            ],
            [
                'name' => 'user',
                'display_name' => 'User',
                'description' => 'A normal user who can fill the form',
            ]
        ]);

        // Create role if not exist yet
        foreach ($roles as $role) {
            if (!Role::where('name', $role['name'])->exists()) {
                Role::create([
                    'name' => $role['name'],
                    'display_name' => $role['display_name'],
                    'description' => $role['description'],
                ]);
            }
        }
    }

    private function createAndDeletePermission()
    {
        $permissions = $this->permissions();

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission['name']],
                [
                    'display_name' => $permission['display_name'], 'group' => $permission['group'],
                    'description' => $permission['description']
                ]
            );
        }

        // Delete permission not in seeder array
        $unusedPermissions = Permission::whereNotIn('name', $permissions->pluck('name'))->get();
        foreach ($unusedPermissions as $unusedPermission) {
            $unusedPermission->delete();
        }
    }

    private function syncRolesPermissions()
    {
        $roles_permissions = [
            'superadmin' => [
                'profile',
                'update-password',
                'delete-account',
                'browse-roles',
                'read-roles',
                'edit-roles',
                'add-roles',
                'delete-roles',
                'browse-permissions',
                'read-permissions',
                'browse-users',
                'read-users',
                'edit-users',
                'add-users',
                'delete-users',
                'browse-posts',
                'read-posts',
                'edit-posts',
                'add-posts',
                'delete-posts',
            ],
            'user' => [
                'profile',
                'update-password',
                'delete-account',
                'browse-posts',
                'read-posts',
                'edit-posts',
                'add-posts',
                'delete-posts',
            ],
        ];

        foreach ($roles_permissions as $index => $value) {
            $role = Role::findByName($index);
            $role->syncPermissions($value);
        }
    }

    public function groups(): Collection
    {
        return collect([
            'profile' => 'profile',
            'roles' => 'roles',
            'permissions' => 'permissions',
            'users' => 'users',
            'posts' => 'posts',
        ]);
    }

    public function permissions(): Collection
    {
        $groups = $this->groups();

        return collect([
            [
                'name' => 'profile',
                'display_name' => 'profile',
                'group' => $groups['profile'],
                'description' => 'view_profile_information',
            ],
            [
                'name' => 'update-password',
                'display_name' => 'update_password',
                'group' => $groups['profile'],
                'description' => 'update_user_password',
            ],
            [
                'name' => 'delete-account',
                'display_name' => 'delete_account',
                'group' => $groups['profile'],
                'description' => 'delete_current_user_account',
            ],
            [
                'name' => 'browse-roles',
                'display_name' => 'browse_roles',
                'group' => $groups['roles'],
                'description' => 'list_of_all_role',
            ],
            [
                'name' => 'read-roles',
                'display_name' => 'read_roles',
                'group' => $groups['roles'],
                'description' => 'read_the_selected_role',
            ],
            [
                'name' => 'edit-roles',
                'display_name' => 'edit_roles',
                'group' => $groups['roles'],
                'description' => 'edit_the_selected_role',
            ],
            [
                'name' => 'add-roles',
                'display_name' => 'add_roles',
                'group' => $groups['roles'],
                'description' => 'add_specific_role',
            ],
            [
                'name' => 'delete-roles',
                'display_name' => 'delete_roles',
                'group' => $groups['roles'],
                'description' => 'delete_the_selected_role',
            ],
            [
                'name' => 'browse-permissions',
                'display_name' => 'browse_permissions',
                'group' => $groups['permissions'],
                'description' => 'list_of_all_permission',
            ],
            [
                'name' => 'read-permissions',
                'display_name' => 'read_permissions',
                'group' => $groups['permissions'],
                'description' => 'read_the_selected_permission',
            ],
            [
                'name' => 'browse-users',
                'display_name' => 'browse_users',
                'group' => $groups['users'],
                'description' => 'list_of_all_user',
            ],
            [
                'name' => 'read-users',
                'display_name' => 'read_users',
                'group' => $groups['users'],
                'description' => 'read_the_selected_user',
            ],
            [
                'name' => 'edit-users',
                'display_name' => 'edit_users',
                'group' => $groups['users'],
                'description' => 'edit_account_for_selected_user',
            ],
            [
                'name' => 'add-users',
                'display_name' => 'add_users',
                'group' => $groups['users'],
                'description' => 'add_account_for_user',
            ],
            [
                'name' => 'delete-users',
                'display_name' => 'delete_users',
                'group' => $groups['users'],
                'description' => 'delete_account_for_selected_user',
            ],
            [
                'name' => 'browse-posts',
                'display_name' => 'browse_posts',
                'group' => $groups['users'],
                'description' => 'list_of_all_user',
            ],
            [
                'name' => 'read-posts',
                'display_name' => 'read_posts',
                'group' => $groups['posts'],
                'description' => 'read_the_selected_post',
            ],
            [
                'name' => 'edit-posts',
                'display_name' => 'edit_posts',
                'group' => $groups['posts'],
                'description' => 'edit_the_selected_posts',
            ],
            [
                'name' => 'add-posts',
                'display_name' => 'add_posts',
                'group' => $groups['users'],
                'description' => 'add_posts',
            ],
            [
                'name' => 'delete-posts',
                'display_name' => 'delete_posts',
                'group' => $groups['posts'],
                'description' => 'delete_the_selected_post',
            ],
        ]);
    }
}
