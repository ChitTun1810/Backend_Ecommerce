<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // admin
        $permissions = Permission::all();
        Role::findByName('admin')->givePermissionTo($permissions);
        Role::findByName('manager')->givePermissionTo($permissions);
        Role::findByName('staff')->givePermissionTo($permissions);
    }
}
