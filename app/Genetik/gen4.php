<?php

namespace App\Genetik;

use App\Models\Pengampu;
use App\Models\Jam;
use App\Models\Hari;
use App\Models\Ruangan;
use App\Models\Jadwal;

class GeneticAlgorithm
{
    private $populasi;
    private $generasi;
    private $crossoverRate;
    private $mutationRate;
    private $individu = [];
    private $pengampu = [];
    private $sks = [];
    private $dosen = [];
    private $jam = [];
    private $hari = [];
    private $ruangan = [];

    public function __construct()
    {
        $this->populasi = 10; // Contoh jumlah populasi
        $this->generasi = 100; // Jumlah generasi
        $this->crossoverRate = 0.7; // Probabilitas crossover
        $this->mutationRate = 0.01; // Probabilitas mutasi
    }

    public function generateJadwal()
    {
        $this->ambilData();
        $this->inisialisasi();
        $fitness = $this->hitungFitness();

        for ($generasi = 0; $generasi < $this->generasi; $generasi++) {
            $this->seleksi($fitness);
            $this->startCrossOver();
            $fitness = $this->mutasi();
        }

        $bestIndex = array_keys($fitness, max($fitness))[0];
        $jadwalTerbaik = $this->individu[$bestIndex];

        foreach ($jadwalTerbaik as $jadwal) {
            Jadwal::create([
                'ruangan_id' => $jadwal[3],
                'jam_id' => $jadwal[1],
                'hari_id' => $jadwal[2],
                'kelas_id' => Pengampu::find($jadwal[0])->kelas_id,
                'pengampu_id' => $jadwal[0],
                'fitness' => max($fitness)
            ]);
        }

        return $jadwalTerbaik;
    }

    private function ambilData()
    {
        $pengampu = Pengampu::with('matkul', 'dosen')->get();

        foreach ($pengampu as $data) {
            $this->pengampu[] = $data->id;
            $this->sks[] = $data->matkul->sks;
            $this->dosen[] = $data->dosen->id;
        }

        $this->jam = Jam::pluck('id')->toArray();
        $this->hari = Hari::pluck('id')->toArray();
        $this->ruangan = Ruangan::pluck('id')->toArray();
    }

    private function inisialisasi()
    {
        $jumlahPengampu = count($this->pengampu);
        $jumlahJam = count($this->jam);
        $jumlahHari = count($this->hari);
        $jumlahRuangan = count($this->ruangan);

        for ($i = 0; $i < $this->populasi; $i++) {
            for ($j = 0; $j < $jumlahPengampu; $j++) {
                $this->individu[$i][$j][0] = $this->pengampu[$j];
                $this->individu[$i][$j][1] = $this->jam[array_rand($this->jam)];
                $this->individu[$i][$j][2] = $this->hari[array_rand($this->hari)];
                $this->individu[$i][$j][3] = $this->ruangan[array_rand($this->ruangan)];
            }
        }
    }

    private function cekFitness($indv)
    {
        $penalty = 0;
        $jumlahPengampu = count($this->pengampu);

        for ($i = 0; $i < $jumlahPengampu; $i++) {
            $jamA = $this->individu[$indv][$i][1];
            $hariA = $this->individu[$indv][$i][2];
            $ruangA = $this->individu[$indv][$i][3];
            $dosenA = $this->dosen[$i];

            for ($j = 0; $j < $jumlahPengampu; $j++) {
                if ($i == $j) continue;

                $jamB = $this->individu[$indv][$j][1];
                $hariB = $this->individu[$indv][$j][2];
                $ruangB = $this->individu[$indv][$j][3];
                $dosenB = $this->dosen[$j];

                if ($jamA == $jamB && $hariA == $hariB && $ruangA == $ruangB) $penalty++;
                if ($jamA == $jamB && $hariA == $hariB && $dosenA == $dosenB) $penalty++;
            }
        }

        return 1 / (1 + $penalty);
    }

    private function hitungFitness()
    {
        $fitness = [];
        for ($i = 0; $i < $this->populasi; $i++) {
            $fitness[$i] = $this->cekFitness($i);
        }
        return $fitness;
    }

    private function seleksi($fitness)
    {
        asort($fitness);
        $indukBaru = [];
        $populasiBaru = [];
        $jumlahIndividu = count($fitness);
        $jumlahTerpilih = round($jumlahIndividu * 0.6);

        $index = 0;
        foreach ($fitness as $key => $value) {
            if ($index >= $jumlahTerpilih) break;
            $indukBaru[] = $key;
            $populasiBaru[] = $this->individu[$key];
            $index++;
        }

        $this->individu = $populasiBaru;
    }

    private function startCrossOver()
    {
        $jumlahIndividu = count($this->individu);
        $jumlahPengampu = count($this->pengampu);
        $individuBaru = [];

        for ($i = 0; $i < $jumlahIndividu; $i += 2) {
            $induk1 = $this->individu[$i];
            $induk2 = $this->individu[$i + 1];

            if (mt_rand() / mt_getrandmax() < $this->crossoverRate) {
                $point = mt_rand(0, $jumlahPengampu - 1);

                for ($j = 0; $j < $point; $j++) {
                    $individuBaru[$i][$j] = $induk1[$j];
                    $individuBaru[$i + 1][$j] = $induk2[$j];
                }
                for ($j = $point; $j < $jumlahPengampu; $j++) {
                    $individuBaru[$i][$j] = $induk2[$j];
                    $individuBaru[$i + 1][$j] = $induk1[$j];
                }
            } else {
                $individuBaru[$i] = $induk1;
                $individuBaru[$i + 1] = $induk2;
            }
        }

        $this->individu = $individuBaru;
    }

    private function mutasi()
    {
        $jumlahIndividu = count($this->individu);
        $jumlahPengampu = count($this->pengampu);
        $jumlahJam = count($this->jam);
        $jumlahHari = count($this->hari);
        $jumlahRuangan = count($this->ruangan);

        for ($i = 0; $i < $jumlahIndividu; $i++) {
            if (mt_rand() / mt_getrandmax() < $this->mutationRate) {
                $j = mt_rand(0, $jumlahPengampu - 1);
                $this->individu[$i][$j][1] = $this->jam[array_rand($this->jam)];
                $this->individu[$i][$j][2] = $this->hari[array_rand($this->hari)];
                $this->individu[$i][$j][3] = $this->ruangan[array_rand($this->ruangan)];
            }
        }

        return $this->hitungFitness();
    }
}
