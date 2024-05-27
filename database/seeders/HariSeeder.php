<?php

//hariSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hari;

class HariSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        foreach ($hari as $key => $name) {
            Hari::create([
                'hari' => $name,
            ]);
        }
    }
}
