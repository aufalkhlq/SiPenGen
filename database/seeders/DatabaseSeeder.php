<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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

        User::truncate();

        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
        ]);
<<<<<<< HEAD

        $this->call([
            KelasSeeder::class,
            DosenSeeder::class,
            MatkulSeeder::class,
            PengampuSeeder::class,
            HariSeeder::class,
            JamSeeder::class,
            RuanganSeeder::class,
        ]);
=======
        $admin->assignRole('admin');

        $academicstaff = User::create([
            'name' => 'academic staff',
            'email' => 'academicstaff@gmail.com',
            'password' => bcrypt('academicstaff'),
        ]);
        $academicstaff->assignRole('academic staff');

        $participant = User::create([
            'name' => 'participant',
            'email' => 'participant@gmail.com',
            'password' => bcrypt('participant'),
        ]);
        $participant->assignRole('participant');
>>>>>>> 865f0411564c207fe6f760c8faabef960c74ff14
    }
}
