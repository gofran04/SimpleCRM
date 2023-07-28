<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;


class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        $permissions = [
            //Roles->G-manager
            'create-role',
            'edit-role',
            'view-role',
            'view-all-roles',
            'delete-role',
            //user(admin)
            'create-user',
            'edit-user',
            'view-user',
            'view-all-users',
            'delete-user',
            //client
            'create-client',
            'edit-client',
            'view-client',
            'view-all-clients',
            'delete-client',
            //project
            'create-project',
            'edit-project',
            'view-project',
            'view-all-projects',
            'delete-project',
            //task
            'create-task',
            'edit-task',
            'view-task',
            'view-all-tasks',
            'delete-task',
            //user(employee)
            'view-profile',
            'edit-profile',
            'update-password',
        ];

        foreach ($permissions as $permission) 
        {
            Permission::create(['name' => $permission]);
        }

        $user_role = Role::create(['guard_name' => 'api','name' => 'user']);
        $user_role->syncPermissions(['view-profile','edit-profile','update-password']);
    }
}
