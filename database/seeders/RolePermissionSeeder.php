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
        Permission::create(['name'=>'menu-dashboard']);
        Permission::create(['name'=>'menu-master-data']);
        Permission::create(['name'=>'menu-generate']);
        Permission::create(['name'=>'menu-hasil-generate']);

        Role::create(['name'=>'admin']);
        Role::create(['name'=>'academic staff']);
        Role::create(['name'=>'participant']);

        $roleAdmin = Role::findByName('admin');
        $roleAdmin->givePermissionTo('menu-dashboard');
        $roleAdmin->givePermissionTo('menu-master-data');
        $roleAdmin->givePermissionTo('menu-generate');
        $roleAdmin->givePermissionTo('menu-hasil-generate');

        $roleAcademicStaff = Role::findByName('academic staff');
        $roleAcademicStaff->givePermissionTo('menu-hasil-generate');

        $roleParticipant = Role::findByName('participant');
        $roleParticipant->givePermissionTo('menu-hasil-generate');
    }
}
