<?php

namespace App\Genetik;

use App\Models\Kelas;
use App\Models\Pengampu;
use App\Models\Jadwal;
use App\Models\Ruangan;
use App\Models\Jam;
use App\Models\Hari;
use Illuminate\Support\Facades\DB;

class GeneticAlgorithm
{
    private $pengampu;
    private $jadwal;
    private $ruangan;
    private $jam;
    private $hari;
    private $kelas;
    private $sks;
    private $mutationRate = 0.01;
    private $maxHoursPerDay = 8;

    public function __construct()
    {
        $this->pengampu = Pengampu::all();
        $this->jadwal = Jadwal::all();
        $this->ruangan = Ruangan::all();
        $this->jam = Jam::all();
        $this->hari = Hari::all();
        $this->kelas = Kelas::all();
        $this->sks = 1; // 1 SKS = 1 jam pelajaran
    }

    public function run($populationSize, $maxGenerations)
    {
        ini_set('max_execution_time', 20000); // Set the maximum execution time to 5 minutes
        $population = $this->initializePopulation($populationSize);

        for ($generation = 0; $generation < $maxGenerations; $generation++) {
            $population = $this->evolvePopulation($population);
        }

        // Get the best schedule
        $bestSchedule = $this->getBestSchedule($population);

        $this->saveJadwal($bestSchedule);

        return $bestSchedule;
    }

    private function getBestSchedule($population)
    {
        usort($population, function ($scheduleA, $scheduleB) {
            return $this->calculateFitness($scheduleA) - $this->calculateFitness($scheduleB);
        });

        return $population[0]; // Return the schedule with the lowest fitness score
    }

    private function initializePopulation($populationSize)
    {
        $population = [];

        for ($i = 0; $i < $populationSize; $i++) {
            $schedule = $this->createSchedule();
            $population[] = $schedule;
        }

        return $population;
    }

    private function createSchedule()
    {
        $schedule = [];

        foreach ($this->kelas as $kelas) {
            $schedule[$kelas->id] = $this->createClassSchedule($kelas);
        }

        return $schedule;
    }

    private function createClassSchedule($kelas)
    {
        $classSchedule = [];

        foreach ($this->hari as $hari) {
            $classSchedule[$hari->id] = $this->createDaySchedule($kelas, $hari);
        }

        return $classSchedule;
    }

    private function createDaySchedule($kelas, $hari)
    {
        $daySchedule = [];
        $subjects = $this->pengampu->shuffle();
        $subjectCount = 0;
        $hoursScheduled = 0;

        foreach ($this->jam as $jam) {
            if ($hoursScheduled >= $this->maxHoursPerDay || $subjectCount >= count($subjects)) {
                break;
            }

            $subject = $subjects[$subjectCount];
            $daySchedule[] = [
                'kelas_id' => $kelas->id,
                'hari_id' => $hari->id,
                'ruangan_id' => $this->ruangan->random()->id,
                'jam_id' => $jam->id,
                'pengampu_id' => $subject->id,
            ];

            $hoursScheduled++;
            $subjectCount++;
        }

        return $daySchedule;
    }

    private function evolvePopulation($population)
    {
        $newPopulation = [];

        for ($i = 0; $i < count($population); $i++) {
            $scheduleA = $this->tournamentSelection($population);
            $scheduleB = $this->tournamentSelection($population);

            $newSchedule = $this->crossover($scheduleA, $scheduleB);
            $newSchedule = $this->mutate($newSchedule);

            $newPopulation[] = $newSchedule;
        }
        return $newPopulation;
    }

    private function tournamentSelection($population, $tournamentSize = 3)
    {
        $tournament = [];
        for ($i = 0; $i < $tournamentSize; $i++) {
            $tournament[] = $population[array_rand($population)];
        }

        usort($tournament, function ($scheduleA, $scheduleB) {
            return $this->calculateFitness($scheduleA) - $this->calculateFitness($scheduleB);
        });

        return $tournament[0];
    }

    private function crossover($scheduleA, $scheduleB)
    {
        $newSchedule = [];

        foreach ($scheduleA as $kelasId => $classSchedule) {
            if (rand(0, 1) === 0) {
                $newSchedule[$kelasId] = $classSchedule;
            } else {
                $newSchedule[$kelasId] = $scheduleB[$kelasId];
            }
        }

        return $newSchedule;
    }

    private function mutate($schedule)
    {
        foreach ($schedule as $kelasId => $classSchedule) {
            if (rand(0, 100) / 100 < $this->mutationRate) {
                // Ensure that $classSchedule has elements before accessing array keys
                if (!empty($classSchedule)) {
                    $dayIndex = array_rand($classSchedule);
                    $daySchedule = $classSchedule[$dayIndex];

                    // Ensure the 'hari_id' key exists before accessing it
                    if (isset($daySchedule[0]['hari_id'])) {
                        $schedule[$kelasId][$dayIndex] = $this->createDaySchedule(
                            Kelas::find($kelasId),
                            Hari::find($daySchedule[0]['hari_id'])
                        );
                    }
                }
            }
        }
        return $schedule;
    }

    private function calculateFitness($schedule)
    {
        $fitness = 0;

        foreach ($schedule as $kelasId => $classSchedule) {
            foreach ($classSchedule as $hariId => $daySchedule) {
                $fitness += $this->checkSchedule($daySchedule);
            }
        }

        return $fitness;
    }

    private function checkSchedule($daySchedule)
    {
        $fitness = 0;

        foreach ($daySchedule as $schedule) {
            $checkPengampu = Jadwal::where('pengampu_id', $schedule['pengampu_id'])
                ->where('jam_id', $schedule['jam_id'])
                ->where('hari_id', $schedule['hari_id'])
                ->count();

            $checkRuangan = Jadwal::where('ruangan_id', $schedule['ruangan_id'])
                ->where('jam_id', $schedule['jam_id'])
                ->where('hari_id', $schedule['hari_id'])
                ->count();

            $checkKelas = Jadwal::where('kelas_id', $schedule['kelas_id'])
                ->where('jam_id', $schedule['jam_id'])
                ->where('hari_id', $schedule['hari_id'])
                ->count();

            if ($checkPengampu > 1) {
                $fitness++;
            }

            if ($checkRuangan > 1) {
                $fitness++;
            }

            if ($checkKelas > 1) {
                $fitness++;
            }
        }

        return $fitness;
    }

    public function saveJadwal($schedule)
    {
        foreach ($schedule as $kelasId => $classSchedule) {
            foreach ($classSchedule as $hariId => $daySchedule) {
                foreach ($daySchedule as $slot) {
                    $jadwal = new Jadwal();
                    $jadwal->kelas_id = $slot['kelas_id'];
                    $jadwal->hari_id = $slot['hari_id'];
                    $jadwal->ruangan_id = $slot['ruangan_id'];
                    $jadwal->jam_id = $slot['jam_id'];
                    $jadwal->pengampu_id = $slot['pengampu_id'];
                    $jadwal->save();
                }
            }
        }
    }

    public function getSchedule()
    {
        return DB::table('jadwal')
            ->join('kelas', 'jadwal.kelas_id', '=', 'kelas.id')
            ->join('hari', 'jadwal.hari_id', '=', 'hari.id')
            ->join('jam', 'jadwal.jam_id', '=', 'jam.id')
            ->join('ruangan', 'jadwal.ruangan_id', '=', 'ruangan.id')
            ->join('pengampu', 'jadwal.pengampu_id', '=', 'pengampu.id')
            ->select('kelas.nama as kelas', 'hari.nama as hari', 'jam.jam as jam', 'ruangan.nama as ruangan', 'pengampu.nama as pengampu')
            ->get();
    }

}
