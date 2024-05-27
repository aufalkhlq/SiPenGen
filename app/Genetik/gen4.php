<?php

namespace App\Genetik;

use App\Models\Kelas;
use App\Models\Pengampu;
use App\Models\Jadwal;
use App\Models\Ruangan;
use App\Models\Jam;
use App\Models\Hari;
use DB;

class GeneticAlgorithm
{
    private $kelas;
    private $pengampu;
    private $jadwal;
    private $ruangan;
    private $jam;
    private $hari;

    public function __construct()
    {
        $this->kelas = Kelas::all();
        $this->pengampu = Pengampu::inRandomOrder()->get();
        $this->jadwal = new Jadwal();
        $this->ruangan = Ruangan::inRandomOrder()->get();
        $this->jam = Jam::inRandomOrder()->get();
        $this->hari = Hari::inRandomOrder()->get();
    }

    public function randomingProcess($classId, $day, $attempt = 0)
    {
        ini_set('max_execution_time', 3000); // 5 minutes

        // Get random pengampu, ruangan, jam, and hari IDs directly
        $pengampuId = Pengampu::inRandomOrder()->value('id');
        $ruanganId = Ruangan::inRandomOrder()->value('id');
        $jamId = Jam::inRandomOrder()->value('id');
        $hariId = Hari::inRandomOrder()->value('id');

        $params = [
            'pengampu_id' => $pengampuId,
            'ruangan_id' => $ruanganId,
            'jam_id' => $jamId,
            'hari_id' => $hariId, // Use the provided day ID
            'kelas_id' => $classId,
        ];

        // Check for existing schedule directly using exists() method
        $scheduleExists = Jadwal::where($params)->exists();

        if ($scheduleExists) {
            $attempt++;
            if ($attempt > 10) { // Stop after 100 attempts
                return null;
            }
            return $this->randomingProcess($classId, $day, $attempt);
        }

        return $params;
    }

    public function run($populationSize, $maxGenerations)
    {
        $schedules = [];
        $fitnessScores = [];

        // Generate initial population
        for ($i = 0; $i < $populationSize; $i++) {
            $schedule = $this->generateSchedule();
            $schedules[] = $schedule;
        }

        // Calculate fitness score for each schedule
        foreach ($schedules as $schedule) {
            $fitnessScore = $this->calculateFitness($schedule);
            $fitnessScores[] = $fitnessScore;
        }

        // Sort schedules based on fitness score
        array_multisort($fitnessScores, SORT_DESC, $schedules);

        // Evolve population
        for ($generation = 0; $generation < $maxGenerations; $generation++) {
            $newPopulation = [];

            // Elitism: Keep the best schedules from the previous generation
            for ($i = 0; $i < 2; $i++) {
                $newPopulation[] = $schedules[$i];
            }

            // Crossover: Generate new schedules by combining the best schedules
            while (count($newPopulation) < $populationSize) {
                $parent1 = $this->selectParent($schedules);
                $parent2 = $this->selectParent($schedules);

                $child = $this->crossover($parent1, $parent2);
                $newPopulation[] = $child;
            }

            // Mutate: Randomly change some schedules
            foreach ($newPopulation as $key => $schedule) {
                if (mt_rand(0, 100) / 100 < 0.01) {
                    $newPopulation[$key] = $this->mutate($schedule);
                }
            }

            // Calculate fitness score for each schedule
            $fitnessScores = [];
            foreach ($newPopulation as $schedule) {
                $fitnessScore = $this->calculateFitness($schedule);
                $fitnessScores[] = $fitnessScore;
            }

            // Sort schedules based on fitness score
            array_multisort($fitnessScores, SORT_DESC, $newPopulation);

            $schedules = $newPopulation;
        }

        return $schedules;
    }

    public function generateSchedule()
    {
        $schedules = [];

        foreach ($this->kelas as $class) {
            $classId = $class->id;

            for ($day = 1; $day <= 5; $day++) {
                $params = $this->randomingProcess($classId, $day);
                $schedules[] = $params;
            }
        }

        return $schedules;
    }

    public function calculateFitness($schedule)
    {
        $fitness = 0;

        foreach ($schedule as $params) {
            $conflicts = Jadwal::where('jam_id', $params['jam_id'])
                ->where('hari_id', $params['hari_id'])
                ->whereIn('pengampu_id', [$params['pengampu_id']])
                ->WhereIn('ruangan_id', [$params['ruangan_id']])
                ->WhereIn('kelas_id', [$params['kelas_id']])
                ->count();

            $fitness += $conflicts > 1 ? $conflicts : 0;
        }

        return $fitness;
    }

    public function selectParent($schedules)
    {
        $tournamentSize = 5;
        $tournament = [];

        for ($i = 0; $i < $tournamentSize; $i++) {
            $randomIndex = mt_rand(0, count($schedules) - 1);
            $tournament[] = $schedules[$randomIndex];
        }

        usort($tournament, function ($a, $b) {
            return $this->calculateFitness($a) < $this->calculateFitness($b);
        });

        return $tournament[0];
    }

    public function crossover($parent1, $parent2)
    {
        $split = mt_rand(1, count($parent1) - 1);
        $child = array_merge(array_slice($parent1, 0, $split), array_slice($parent2, $split));

        return $child;
    }

    public function mutate($schedule)
    {
        $randomIndex = mt_rand(0, count($schedule) - 1);
        $schedule[$randomIndex] = $this->randomingProcess($schedule[$randomIndex]['kelas_id'], $schedule[$randomIndex]['hari_id']);

        return $schedule;
    }

    public function saveJadwal($schedules)
    {
        foreach ($schedules as $schedule) {
            Jadwal::create($schedule);
        }
    }

    public function getJadwal()
    {
        return Jadwal::all();
    }

    public function clearJadwal()
    {
        Jadwal::truncate();
    }

}
