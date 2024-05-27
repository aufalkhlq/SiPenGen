<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengampu;

class PengampuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pengampu = [
            ['dosen_id' => 1, 'matkul_id' => [1]],
            ['dosen_id' => 2, 'matkul_id' => [4]],
            ['dosen_id' => 3, 'matkul_id' => [2]],
            ['dosen_id' => 4, 'matkul_id' => [1]],
            ['dosen_id' => 5, 'matkul_id' => [3]],

        ];

        foreach ($pengampu as $key => $value) {
            $pengampu[$key]['matkul_id'] = json_encode($value['matkul_id']);
        }

        foreach ($pengampu as $data) {
            Pengampu::create($data);
        }
    }
}
