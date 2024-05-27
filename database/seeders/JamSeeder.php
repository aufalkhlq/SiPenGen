<?php
//jamseeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class JamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $jam = [
            ['jam' => 1, 'waktu' => '07:00 - 08:40'],
            ['jam' => 2, 'waktu' => '08:50 - 10:30'],
            ['jam' => 3, 'waktu' => '10:40 - 12:20'],
            ['jam' => 4, 'waktu' => '13:00 - 14:40'],
            ['jam' => 5, 'waktu' => '14:50 - 16:30'],
       
        ];

        foreach ($jam as $data) {
            \App\Models\Jam::create($data);
        }

    }
}
