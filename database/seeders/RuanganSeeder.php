<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ruangan;

class RuanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ruanganNames = ['Ruangan 1', 'Ruangan 2', 'Ruangan 3', 'Ruangan 4', 'Ruangan 5'];
        $kapasitas = [20, 30, 40, 50, 60, ];
        //make unique for code not sorted
        $kode = ['R-281', 'R-282', 'R-283', 'R-284', 'R-285'];
        $lantai = ['1','2','3'];

        foreach ($ruanganNames as $key => $name) {
            Ruangan::create([
                'nama_ruangan' => $name,
                'kapasitas' => $kapasitas[$key] ,
                'kode_ruangan' => $kode[$key],
                'lantai' => $lantai[rand(0,2)]
            ]);
        }
    }
}
