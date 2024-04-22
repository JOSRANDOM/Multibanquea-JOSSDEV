<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
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


        // Create permissions

        Permission::create(['name' => 'list affiliates']);
        Permission::create(['name' => 'edit affiliates']);

        Permission::create(['name' => 'list answers']);
        Permission::create(['name' => 'edit answers']);

        Permission::create(['name' => 'list permissions']);
        Permission::create(['name' => 'edit permissions']);

        Permission::create(['name' => 'list promo codes']);
        Permission::create(['name' => 'edit promo codes']);

        Permission::create(['name' => 'list questions']);
        Permission::create(['name' => 'edit questions']);

        Permission::create(['name' => 'list users']);
        Permission::create(['name' => 'edit users']);

        Permission::create(['name' => 'edit subscriptions']);
        Permission::create(['name' => 'import students']);

        // Create roles and assign existing permissions

        $role1 = Role::create(['name' => 'moderator']);
        $role1->givePermissionTo('list affiliates');
        $role1->givePermissionTo('edit affiliates');
        $role1->givePermissionTo('list users');
        $role1->givePermissionTo('edit users');
        $role1->givePermissionTo('list promo codes');
        $role1->givePermissionTo('edit promo codes');

        $role2 = Role::create(['name' => 'admin']);
        $role2->givePermissionTo('list affiliates');
        $role2->givePermissionTo('edit affiliates');
        $role2->givePermissionTo('list answers');
        $role2->givePermissionTo('edit answers');
        $role2->givePermissionTo('list questions');
        $role2->givePermissionTo('edit questions');
        $role2->givePermissionTo('list promo codes');
        $role2->givePermissionTo('edit promo codes');
        $role2->givePermissionTo('list users');
        $role2->givePermissionTo('edit users');
        $role2->givePermissionTo('import students');
        $role1->givePermissionTo('edit subscriptions');

        Role::create(['name' => 'super-admin']); // Gets all permissions via AuthServiceProvider

        Role::create(['name' => 'affiliate']);
    }
}
