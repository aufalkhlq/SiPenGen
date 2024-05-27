<?php

namespace App\Genetik;

use App\Models\Kelas;
use App\Models\Matkul;
use App\Models\Dosen;
use App\Models\Jadwal;
use App\Models\Ruangan;
use App\Models\Jam;
use App\Models\Hari;
use DB;


class GeneticAlgorithm
{
    private $matkul;
    private $dosen;
    private $jadwal;
    private $ruangan;
    private $jam;
    private $hari;

    private $kelas;

    public function __construct()
    {
        $this->matkul = new Matkul();
        $this->dosen = new Dosen();
        $this->jadwal = new Jadwal();
        $this->ruangan = new Ruangan();
        $this->jam = new Jam();
        $this->hari = new Hari();
        $this->kelas = new Kelas();
    }


    public function randomingProcess($classId, $day)
    {
        $dosen = Dosen::inRandomOrder()->first();
        $ruangan = Ruangan::inRandomOrder()->first();
        $jam = Jam::inRandomOrder()->first();
        $matkul = Matkul::inRandomOrder()->first();

        // Access the 'id' property of each object
        $dosenId = $dosen->id;
        $ruanganId = $ruangan->id;
        $jamId = $jam->id;
        $matkulId = $matkul->id;

        $params = [
            'dosen_id' => $dosenId,
            'ruangan_id' => $ruanganId,
            'jam_id' => $jamId,
            'hari_id' => $day->id, // Use the provided day ID
            'matkul_id' => $matkulId,
            'kelas_id' => $classId,
        ];

        // Filter to avoid duplicate schedules
        $jadwal = Jadwal::where('dosen_id', $dosenId)
            ->where('ruangan_id', $ruanganId)
            ->where('jam_id', $jamId)
            ->where('hari_id', $params['hari_id'])
            ->where('matkul_id', $matkulId)
            ->where('kelas_id', $classId)
            ->first();

        if ($jadwal) {
            return $this->randomingProcess($classId, $day);
        }

        return $params;
    }


    public function generatePopulation()
    {
        $data = [];
        $days = Hari::all(); // Get all days
        $classes = Kelas::all();

        foreach ($classes as $class) {
            foreach ($days as $day) {
                $params = $this->randomingProcess($class->id, $day);
                $data[] = $params;
            }
        }

        return $data;
    }


    public function mutation($data)
    {
        foreach ($data as $key => $value) {
            $day = Hari::inRandomOrder()->first(); // Randomly select a day
            $data[$key] = $this->randomingProcess($value['kelas_id'], $day);
        }

        return $data;
    }

    public function fitness($data)
    {
        $fitness = 0;
        $jadwal = Jadwal::all();
        foreach ($jadwal as $key => $value) {
            $fitness += $this->checkJadwal($value);
        }

        return $fitness;
    }

    public function checkJadwal($jadwal)
    {
        $fitness = 0;
        $dosen = Dosen::find($jadwal->dosen_id);
        $ruangan = Ruangan::find($jadwal->ruangan_id);
        $jam = Jam::find($jadwal->jam_id);
        $hari = Hari::find($jadwal->hari_id);
        $matkul = Matkul::find($jadwal->matkul_id);
        $kelas = Kelas::find($jadwal->kelas_id);

        $checkDosen = Jadwal::where('dosen_id', $dosen->id)
            ->where('jam_id', $jam->id)
            ->where('hari_id', $hari->id)
            ->count();

        $checkRuangan = Jadwal::where('ruangan_id', $ruangan->id)
            ->where('jam_id', $jam->id)
            ->where('hari_id', $hari->id)
            ->count();

        $checkKelas = Jadwal::where('kelas_id', $kelas->id)
            ->where('jam_id', $jam->id)
            ->where('hari_id', $hari->id)
            ->count();

        $checkMatkul = Jadwal::where('matkul_id', $matkul->id)
            ->where('jam_id', $jam->id)
            ->where('hari_id', $hari->id)
            ->count();

        if ($checkDosen > 1) {
            $fitness++;
        }

        if ($checkRuangan > 1) {
            $fitness++;
        }

        if ($checkKelas > 1) {
            $fitness++;
        }

        if ($checkMatkul > 1) {
            $fitness++;
        }

        return $fitness;
    }

    public function selection($data)
    {
        $fitness = [];
        foreach ($data as $key => $value) {
            $fitness[] = $this->fitness($value);
        }

        $min = min($fitness);
        $index = array_search($min, $fitness);

        return $data[$index];
    }

    public function crossover($data)
    {
        $data1 = $this->selection($data);
        $data2 = $this->selection($data);

        $split = rand(1, count($data1) - 1);
        $data3 = array_merge(array_slice($data1, 0, $split), array_slice($data2, $split));
        $data4 = array_merge(array_slice($data2, 0, $split), array_slice($data1, $split));

        return [$data3, $data4];
    }



    public function run($population, $generation)
    {
        $data = $this->generatePopulation($population);
        for ($i = 0; $i < $generation; $i++) {
            $data = $this->crossover($data);
            $data = $this->mutation($data);
        }

        return $data;
    }

    public function saveJadwal($data)
    {
        foreach ($data as $key => $value) {
            $jadwal = new Jadwal();
            $jadwal->dosen_id = $value['dosen_id'];
            $jadwal->ruangan_id = $value['ruangan_id'];
            $jadwal->jam_id = $value['jam_id'];
            $jadwal->hari_id = $value['hari_id'];
            $jadwal->matkul_id = $value['matkul_id'];
            $jadwal->kelas_id = $value['kelas_id'];
            $jadwal->save();
        }
    }

    public function getJadwal()
    {
        $jadwal = Jadwal::all();
        $data = [];
        foreach ($jadwal as $key => $value) {
            $data[] = [
                'dosen' => Dosen::find($value->dosen_id)->nama_dosen,
                'ruangan' => Ruangan::find($value->ruangan_id)->nama_ruangan,
                'jam' => Jam::find($value->jam_id)->waktu,
                'hari' => Hari::find($value->hari_id)->hari,
                'matkul' => Matkul::find($value->matkul_id)->nama_matkul,
                'kelas' => Kelas::find($value->kelas_id)->nama_kelas,
            ];
        }

        return $data;
    }



}
