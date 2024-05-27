<?php
namespace App\Genetik;

use App\Models\Kelas;
use App\Models\Pengampu;
use App\Models\Jadwal;
use App\Models\Ruangan;
use App\Models\Jam;
use App\Models\Hari;
use App\Models\Dosen;

class GeneticAlgorithm
{
    private $pengampu;
    private $jadwal;
    private $ruangan;
    private $jam;
    private $hari;
    private $kelas;
    private $sks;

    public function __construct()
    {
        $this->pengampu = Pengampu::all();
        $this->dosen = Dosen::all();
        $this->jadwal = Jadwal::all();
        $this->ruangan = Ruangan::all();
        $this->jam = Jam::all();
        $this->hari = Hari::all();
        $this->kelas = Kelas::all();
        $this->sks = 1; // 1 SKS = 1 jam pelajaran
    }

    public function runGeneticAlgorithm($populationSize, $maxGenerations)
    {
        $population = $this->initializePopulation($populationSize);

        for ($generation = 0; $generation < $maxGenerations; $generation++) {
            $population = $this->evolvePopulation($population);
        }

        // Get the best schedule
        $bestSchedule = $this->getBestSchedule($population);

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
            $schedule = $this->generateRandomSchedule();
            $population[] = $schedule;
        }

        return $population;
    }

    private function generateRandomSchedule()
    {
        $schedule = [];

        foreach ($this->kelas as $kelas) {
            $kelasId = $kelas->id;
            $pengampuId = $this->pengampu->random()->id;
            $jamId = $this->jam->random()->id;
            $hariId = $this->hari->random()->id;
            $ruanganId = $this->ruangan->random()->id;
            $sks = $this->sks;

            $schedule[] = [
                'kelas_id' => $kelasId,
                'pengampu_id' => $pengampuId,
                'jam_id' => $jamId,
                'hari_id' => $hariId,
                'ruangan_id' => $ruanganId,
                'sks' => $sks,
            ];
        }

        return $schedule;
    }

    private function evolvePopulation($population)
    {
        $newPopulation = [];

        $fitnessScores = $this->calculateFitnessScores($population);

        for ($i = 0; $i < count($population); $i++) {
            $parent1 = $this->selectParent($population, $fitnessScores);
            $parent2 = $this->selectParent($population, $fitnessScores);

            $child = $this->crossover($parent1, $parent2);
            $child = $this->mutate($child);

            $newPopulation[] = $child;
        }

        return $newPopulation;
    }

    private function calculateFitnessScores($population)
    {
        $fitnessScores = [];

        foreach ($population as $schedule) {
            $fitness = $this->calculateFitness($schedule);
            $fitnessScores[] = $fitness;
        }

        return $fitnessScores;
    }

    private function calculateFitness($schedule)
    {
        $fitness = 0;
        ini_set('max_execution_time', 600); // Increase max execution time to 10 minutes (600 seconds)

        foreach ($schedule as $params) {
            if (isset($params['jam_id'], $params['hari_id'], $params['pengampu_id'], $params['kelas_id'], $params['ruangan_id'])) {
                $conflicts = Jadwal::where('jam_id', $params['jam_id'])
                    ->where('hari_id', $params['hari_id'])
                    ->where('pengampu_id', $params['pengampu_id'])
                    ->where('kelas_id', $params['kelas_id'])
                    ->where('ruangan_id', $params['ruangan_id'])
                    ->count();

                $fitness += $conflicts > 1 ? $conflicts : 0;
            }
        }

        return $fitness;
    }

    private function selectParent($population, $fitnessScores)
    {
        $tournamentSize = 5;
        $tournament = [];

        for ($i = 0; $i < $tournamentSize; $i++) {
            $randomIndex = mt_rand(0, count($population) - 1);
            $tournament[] = $population[$randomIndex];
        }

        usort($tournament, function ($a, $b) use ($fitnessScores) {
            return $fitnessScores[$this->calculateFitness($a)] < $fitnessScores[$this->calculateFitness($b)];
        });

        return $tournament[0];
    }

    private function crossover($parent1, $parent2)
    {
        $child = [];

        for ($i = 0; $i < count($parent1); $i++) {
            $parent = mt_rand(0, 1);
            $child[] = $parent ? $parent1[$i] : $parent2[$i];
        }

        return $child;
    }

    private function mutate($schedule)
    {
        $mutationRate = 0.01;

        foreach ($schedule as $key => $params) {
            if (mt_rand(0, 100) / 100 < $mutationRate) {
                $schedule[$key] = $this->generateRandomSchedule();
            }
        }

        return $schedule;
    }

    public function saveSchedule($schedule)
    {
        foreach ($schedule as $params) {
            if (isset($params['jam_id'], $params['hari_id'], $params['pengampu_id'], $params['kelas_id'], $params['ruangan_id'])) {
                $jadwal = new Jadwal();
                $jadwal->jam_id = $params['jam_id'];
                $jadwal->hari_id = $params['hari_id'];
                $jadwal->pengampu_id = $params['pengampu_id'];
                $jadwal->kelas_id = $params['kelas_id'];
                $jadwal->ruangan_id = $params['ruangan_id'];
                $jadwal->sks = $params['sks'];

                if (!$jadwal->save()) {
                    // Log if save fails
                    // var_dump('Failed to save schedule:', $params);
                }
            } else {
                // Log if any key is missing
                // var_dump('Missing keys in schedule:', $params);
            }
        }
    }
}
