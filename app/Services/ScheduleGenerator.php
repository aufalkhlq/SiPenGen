<?php

namespace App\Services;

use App\Models\{Hari, Jam, Kelas, Matkul, Pengampu, Ruangan, Jadwal};
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class ScheduleGenerator
{
    private $population;
    private $populationSize = 5; // Reduced size for faster testing
    private $generations = 10; // Reduced number of generations for testing
    private $mutationRate = 0.05; // Reduced mutation rate for testing

    public function __construct()
    {
        $this->population = collect();
    }

    public function generate()
    {
        ini_set('max_execution_time', 20000);

        Log::info('Starting schedule generation');

        $haris = Hari::all();
        $jams = Jam::all();
        $ruangans = Ruangan::all();
        $kelas = Kelas::all();
        $pengampus = Pengampu::with('dosen', 'matkul')->get();

        if ($haris->isEmpty() || $jams->isEmpty() || $ruangans->isEmpty() || $kelas->isEmpty() || $pengampus->isEmpty()) {
            Log::error("Data for scheduling is insufficient.");
            throw new \Exception("Insufficient data to generate the schedule.");
        }

        Log::info('Data retrieved successfully');

        $this->initializePopulation($haris, $jams, $ruangans, $kelas, $pengampus);

        for ($generation = 0; $generation < $this->generations; $generation++) {
            Log::info("Generation {$generation} start");
            $this->evaluateFitness();
            $this->selection();
            $this->crossover();
            $this->mutation($jams);
            Log::info("Generation {$generation} end");

            if ($generation % 5 == 0) {
                Log::info("Generation info", ['generation' => $generation, 'best_fitness' => $this->population->max('fitness')]);
            }
        }

        $bestSchedule = $this->selectBestSchedule();
        $this->saveSchedule($bestSchedule);

        Log::info('Schedule generation completed');
        return $bestSchedule;
    }

    private function initializePopulation($haris, $jams, $ruangans, $kelas, $pengampus)
    {
        Log::info('Initializing population');
        for ($i = 0; $i < $this->populationSize; $i++) {
            $schedule = $this->createRandomSchedule($haris, $jams, $ruangans, $kelas, $pengampus);
            $this->population->push($schedule);
            Log::info("Initialized individual {$i}");
        }
        Log::info('Population initialized');
    }

    private function createRandomSchedule($haris, $jams, $ruangans, $kelas, $pengampus)
    {
        $schedule = collect();

        foreach ($kelas as $kelasItem) {
            $remainingHours = 40;
            $lastScheduledTime = [];

            foreach ($pengampus as $pengampu) {
                $matkul = $pengampu->matkul;
                $timeSlots = $matkul->sks * 2;
                $daysScheduled = [];

                for ($i = 0; $i < $timeSlots; $i++) {
                    if ($remainingHours > 0) {
                        do {
                            $hari = $haris->random();
                        } while (in_array($hari->id, $daysScheduled) && count($daysScheduled) >= 2);

                        if (!in_array($hari->id, $daysScheduled)) {
                            $daysScheduled[] = $hari->id;
                        }

                        $ruangan = $ruangans->random();
                        $jam = $jams->random();

                        if (isset($lastScheduledTime[$matkul->id][$kelasItem->id][$hari->id])) {
                            $previousSlot = $lastScheduledTime[$matkul->id][$kelasItem->id][$hari->id];
                            $jam = $jams->where('id', '>', $previousSlot['jam_id'])->first() ?? $jams->first();
                            $ruangan = $previousSlot['ruangan_id'];
                        }

                        if ($jam->id == 4 || $jam->id == 7 || $jam->id == 10) {
                            continue;
                        }

                        $schedule->push([
                            'pengampu_id' => $pengampu->id,
                            'hari_id' => $hari->id,
                            'jam_id' => $jam->id,
                            'ruangan_id' => $ruangan->id,
                            'matkul_id' => $matkul->id,
                            'dosen_id' => $pengampu->dosen->id,
                            'kelas_id' => $kelasItem->id
                        ]);

                        $lastScheduledTime[$matkul->id][$kelasItem->id][$hari->id] = [
                            'jam_id' => $jam->id,
                            'ruangan_id' => $ruangan
                        ];

                        $remainingHours--;
                    }
                }
            }
        }

        return $schedule;
    }

    private function evaluateFitness()
    {
        Log::info('Evaluating fitness');
        $this->population->each(function ($chromosome) {
            $conflictCount = $this->countConflicts($chromosome);
            $chromosome->put('fitness', 1 / (1 + $conflictCount));
        });
        Log::info('Fitness evaluated');
    }

    private function countConflicts($schedule)
    {
        $conflictCount = 0;

        $groupByRoomAndTime = $schedule->groupBy(['ruangan_id', 'hari_id', 'jam_id']);
        foreach ($groupByRoomAndTime as $group) {
            if ($group->count() > 1) {
                $conflictCount += $group->count() - 1;
            }
        }

        $groupByDosenAndTime = $schedule->groupBy(['dosen_id', 'hari_id', 'jam_id']);
        foreach ($groupByDosenAndTime as $group) {
            if ($group->count() > 1) {
                $conflictCount += $group->count() - 1;
            }
        }

        $groupByClassAndTime = $schedule->groupBy(['kelas_id', 'hari_id', 'jam_id']);
        foreach ($groupByClassAndTime as $group) {
            if ($group->count() > 1) {
                $conflictCount += $group->count() - 1;
            }
        }

        return $conflictCount;
    }

    private function selection()
    {
        Log::info('Selection process start');
        $newPopulation = collect();
        for ($i = 0; $i < $this->populationSize; $i++) {
            $tournament = $this->population->random(3);
            $winner = $tournament->sortByDesc('fitness')->first();
            $newPopulation->push($winner);
        }
        $this->population = $newPopulation;
        Log::info('Selection process end');
    }

    private function crossover()
    {
        Log::info('Crossover process start');
        $newPopulation = collect();
        while ($newPopulation->count() < $this->populationSize) {
            $parent1 = $this->population->random();
            $parent2 = $this->population->random();
            $crossoverIndex = rand(0, $parent1->count() - 1);

            $child1 = $parent1->slice(0, $crossoverIndex)->merge($parent2->slice($crossoverIndex));
            $child2 = $parent2->slice(0, $crossoverIndex)->merge($parent1->slice($crossoverIndex));

            $newPopulation->push($child1);
            if ($newPopulation->count() < $this->populationSize) {
                $newPopulation->push($child2);
            }
        }
        $this->population = $newPopulation;
        Log::info('Crossover process end');
    }

    private function mutation($jams)
    {
        Log::info('Mutation process start');
        if ($jams->isEmpty()) {
            Log::error("No jam entries available for mutation.");
            return;
        }

        $this->population->transform(function ($chromosome) use ($jams) {
            if (rand(0, 100) / 100 < $this->mutationRate) {
                $index = rand(0, $chromosome->count() - 1);
                if (isset($chromosome[$index]) && is_array($chromosome[$index])) {
                    $gene = $chromosome[$index];
                    $gene['jam_id'] = $jams->random()->id;
                    $chromosome[$index] = $gene;
                } else {
                    Log::warning("Mutation index out of bounds or invalid type", [
                        'index' => $index,
                        'chromosome_size' => $chromosome->count()
                    ]);
                }
            }
            return $chromosome;
        });
        Log::debug("Mutation applied to population");
        Log::info('Mutation process end');
    }

    private function selectBestSchedule()
    {
        return $this->population->sortByDesc('fitness')->first();
    }

    private function saveSchedule($schedule)
    {
        foreach ($schedule as $item) {
            Jadwal::create([
                'pengampu_id' => $item['pengampu_id'],
                'hari_id'     => $item['hari_id'],
                'jam_id'      => $item['jam_id'],
                'ruangan_id'  => $item['ruangan_id'],
                'kelas_id'    => $item['kelas_id'],
            ]);
        }
        Log::info('Schedule saved');
    }
}
