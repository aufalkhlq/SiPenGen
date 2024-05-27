<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kelasNames = ['IK1A', 'IK1B', 'IK1C'];

        foreach ($kelasNames as $name) {
            Kelas::create([
                'nama_kelas' => $name,
                'tahun_angkatan' => '2022',
                'prodi' => 'Teknik Informatika',
            ]);
        }
    }
}
