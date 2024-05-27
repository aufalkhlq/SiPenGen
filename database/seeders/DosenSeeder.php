<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dosen;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dosenNames = ['Dosen 1', 'Dosen 2', 'Dosen 3', 'Dosen 4', 'Dosen 5'];
        //make unique NIP not sorted
        $nip = ['1234567890', '2345678901', '3456789012', '4567890123', '5678901234'];

        foreach ($dosenNames as $key => $name) {
            Dosen::create([
                'nama_dosen' => $name,
                'nip' => $nip[$key],
                'prodi' => 'Teknik Informatika',
            ]);
        }
    }
}
