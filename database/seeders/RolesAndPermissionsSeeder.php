<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        Permission::create(['name' => 'create posts']);
        Permission::create(['name' => 'edit posts']);
        Permission::create(['name' => 'delete posts']);
        Permission::create(['name' => 'publish posts']);
        Permission::create(['name' => 'manage categories']);
        Permission::create(['name' => 'manage users']);

        // Create roles and assign permissions
        $role = Role::create(['name' => 'writer']);
        $role->givePermissionTo(['create posts', 'edit posts', 'delete posts']);

        $role = Role::create(['name' => 'editor']);
        $role->givePermissionTo(['create posts', 'edit posts', 'delete posts', 'publish posts']);

        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(Permission::all());
    }
}
