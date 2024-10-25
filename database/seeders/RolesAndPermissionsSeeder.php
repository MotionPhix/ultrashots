<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      Permission::firstOrCreate(['name' => 'add users', 'guard_name' => 'web']);

      // Define permissions
      Permission::create(['name' => 'edit contacts']);
      Permission::create(['name' => 'delete contacts']);
      Permission::create(['name' => 'create contacts']);
      Permission::create(['name' => 'view contacts']);
      Permission::create(['name' => 'view users']);
      Permission::create(['name' => 'create users']);
      Permission::create(['name' => 'delete users']);
      Permission::create(['name' => 'edit users']);
      Permission::create(['name' => 'ban users']);
      Permission::create(['name' => 'assign user roles']);
      Permission::create(['name' => 'assign role permissions']);
      Permission::create(['name' => 'create email templates']);
      Permission::create(['name' => 'delete email templates']);
      Permission::create(['name' => 'use email templates']);
      Permission::create(['name' => 'send email campaigns']);
      Permission::create(['name' => 'view analytics']);

      // Super Admin permission
      Permission::create(['name' => 'delete companies']);
      Permission::create(['name' => 'ban companies']);
      Permission::create(['name' => 'view companies']);

      // Define roles
      $superAdmin = Role::create(['name' => 'Super Admin']);
      $admin = Role::create(['name' => 'Company Admin']);
      $emailMarketer = Role::create(['name' => 'Email Marketer']);
      $staff = Role::create(['name' => 'Staff']);

      // IMPORTANT!
      app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

      // Assign permissions to roles
      $superAdmin->givePermissionTo(Permission::all()); // All permissions

      $admin->givePermissionTo([
        'edit contacts', 'send email campaigns', 'view analytics',
        'create contacts', 'delete contacts', 'view contacts', 'ban users',
        'edit users', 'add users', 'delete users', 'create users', 'assign user roles',
        'assign role permissions'
      ]);

      $emailMarketer->givePermissionTo([
        'send email campaigns', 'view analytics'
      ]);

      $staff->givePermissionTo(['view contacts']);

      // IMPORTANT!
      app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
