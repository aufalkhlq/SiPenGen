<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Matkul;
class MatkulSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $matkulNames = ['Matkul 1', 'Matkul 2', 'Matkul 3', 'Matkul 4', 'Matkul 5', ];
        $sks = [2, 3, 4, 2, 3, 4];
        //make unique for code not sorted
        $kode = ['BA-281', 'BA-282', 'BA-283', 'BA-284', 'BA-285'];

        foreach ($matkulNames as $key => $name) {
            Matkul::create([
                'nama_matkul' => $name,
                'sks' => $sks[$key] ,
                'kode_matkul' => $kode[$key],
            ]);
        }
    }
}
