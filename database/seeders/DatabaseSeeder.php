<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'admin',
        //     'email' => 'admin@gmail.com',
        //     'password' => bcrypt('password'),
        // ]);

        $this->call([
            RolePermissionSeeder::class,
            KelasSeeder::class,
            DosenSeeder::class,
            MatkulSeeder::class,
            // PengampuSeeder::class,
            HariSeeder::class,
            JamSeeder::class,
            RuanganSeeder::class,
        ]);

        // Create users and assign roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $academicStaffRole = Role::firstOrCreate(['name' => 'academic staff']);
        $participantRole = Role::firstOrCreate(['name' => 'participant']);

        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole($adminRole);


    }
}
