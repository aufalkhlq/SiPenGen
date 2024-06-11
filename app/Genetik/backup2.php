<?php
namespace App\Genetik;

use App\Models\Kelas;
use App\Models\Pengampu;
use App\Models\Jadwal;
use App\Models\Ruangan;
use App\Models\Jam;
use App\Models\Hari;
use App\Models\Matkul;
use Illuminate\Support\Facades\DB;

class GeneticAlgorithm
{
    private $pengampu;
    private $jadwal;
    private $ruangan;
    private $jam;
    private $hari;
    private $kelas;
    private $matkul;
    private $sks;
    private $mutationRate = 0.01;

    public function __construct()
    {
        $this->pengampu = Pengampu::all();
        $this->jadwal = Jadwal::all();
        $this->ruangan = Ruangan::all();
        $this->jam = Jam::all();
        $this->hari = Hari::all();
        $this->kelas = Kelas::all();
        $this->matkul = Matkul::all();
        $this->sks = 1; // 1 SKS = 2 jam pelajaran (2 hours)
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
        $remainingHours = 8; // Maximum 8 hours per day

        while ($remainingHours > 0) {
            $matkul = $this->matkul->random();
            $sks = $matkul->sks * 2; // 1 SKS = 2 hours

            if ($remainingHours >= $sks) {
                $session = [
                    'kelas_id' => $kelas->id,
                    'hari_id' => $hari->id,
                    'ruangan_id' => $this->ruangan->random()->id,
                    'pengampu_id' => $this->pengampu->random()->id,
                    'matkul_id' => $matkul->id,
                    'sks' => $sks,
                ];

                for ($i = 0; $i < $sks; $i++) {
                    $session['jam_id'][] = $this->jam->random()->id;
                }

                $daySchedule[] = $session;
                $remainingHours -= $sks;
            } else {
                break;
            }
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
        foreach ($schedule as $kelasId => &$classSchedule) {
            if (rand(0, 100) / 100 < $this->mutationRate) {
                $dayIndex = array_rand($classSchedule);
                $newDaySchedule = $this->createDaySchedule(Kelas::find($kelasId), Hari::find($dayIndex));

                foreach ($newDaySchedule as $newSession) {
                    $classSchedule[$dayIndex][] = $newSession;
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
                foreach ($daySchedule as $session) {
                    $fitness += $this->checkSchedule($session);
                }
            }
        }

        return $fitness;
    }

    private function checkSchedule($session)
    {
        $fitness = 0;

        $jamIds = $session['jam_id'];
        foreach ($jamIds as $jamId) {
            $checkPengampu = Jadwal::where('pengampu_id', $session['pengampu_id'])
                ->where('jam_id', $jamId)
                ->where('hari_id', $session['hari_id'])
                ->count();

            $checkRuangan = Jadwal::where('ruangan_id', $session['ruangan_id'])
                ->where('jam_id', $jamId)
                ->where('hari_id', $session['hari_id'])
                ->count();

            $checkKelas = Jadwal::where('kelas_id', $session['kelas_id'])
                ->where('jam_id', $jamId)
                ->where('hari_id', $session['hari_id'])
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
                foreach ($daySchedule as $session) {
                    foreach ($session['jam_id'] as $jamId) {
                        $jadwal = new Jadwal();
                        $jadwal->kelas_id = $kelasId;
                        $jadwal->hari_id = $hariId;
                        $jadwal->ruangan_id = $session['ruangan_id'];
                        $jadwal->jam_id = $jamId;
                        $jadwal->pengampu_id = $session['pengampu_id'];
                        $jadwal->matkul_id = $session['matkul_id'];
                        $jadwal->save();
                    }
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
            ->join('matkul', 'jadwal.matkul_id', '=', 'matkul.id')
            ->select('kelas.nama as kelas', 'hari.nama as hari', 'jam.jam as jam', 'ruangan.nama as ruangan', 'pengampu.nama as pengampu', 'matkul.nama as matkul')
            ->get();
    }
}
