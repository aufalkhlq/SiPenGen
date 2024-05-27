<?php

namespace App\Genetik;

use App\Genetik\Individual;
use App\Genetik\Population;
use App\Models\Jadwal;

class GeneticAlgorithm
{
    private $populationSize;
    private $mutationRate;
    private $crossoverRate;
    private $elitismCount;
    private $tournamentSize;
    private $kelas = array();
    private $jadwal = array();
    private $jam = array();
    private $hari = array();
    private $pengampu = array();
    private $ruangan = array();
    private $fitness;

    public function __construct($jadwal, $kelas, $ruangan, $jam, $hari, $pengampu, $populationSize, $mutationRate, $crossoverRate, $elitismCount, $tournamentSize)
    {
        $this->jadwal = $jadwal;
        $this->kelas = $kelas;
        $this->ruangan = $ruangan;
        $this->jam = $jam;
        $this->hari = $hari;
        $this->pengampu = $pengampu;
        $this->populationSize = $populationSize;
        $this->mutationRate = $mutationRate;
        $this->crossoverRate = $crossoverRate;
        $this->elitismCount = $elitismCount;
        $this->tournamentSize = $tournamentSize;
    }

    public function initPopulation()
    {
        $population = new Population($this->populationSize, $this->jadwal);
        return $population;
    }

    public function calculateFitness(Individual $individual)
    {
        $fitness = 0;
        $jadwal = $individual->getJadwal();

        if (!empty($jadwal)) {
            foreach ($jadwal as $key => $value) {
                $kelas_id = $value['kelas_id'];
                $ruangan_id = $value['ruangan_id'];
                $jam_id = $value['jam_id'];
                $hari_id = $value['hari_id'];
                $pengampu_id = $value['pengampu_id'];

                $kelas = $this->getFirstWhere('kelas', 'id', $kelas_id);
                $ruangan = $this->getFirstWhere('ruangan', 'id', $ruangan_id);
                $jam = $this->getFirstWhere('jam', 'id', $jam_id);
                $hari = $this->getFirstWhere('hari', 'id', $hari_id);
                $pengampu = $this->getFirstWhere('pengampu', 'id', $pengampu_id);

                if ($kelas && $ruangan && $jam && $hari && $pengampu) {
                    $jam_waktu = $jam->waktu;
                    $hari_nama = $hari->hari;
                    $ruangan_nama = $ruangan->nama_ruangan;
                    $kelas_nama = $kelas->nama_kelas;
                    $pengampu_dosen = $pengampu->dosen_id;

                    // Perform fitness calculation logic here
                    // For example, check if the schedule is valid

                    $checkJadwal = Jadwal::where('ruangan_id', $ruangan_id)
                        ->where('jam_id', $jam_id)
                        ->where('hari_id', $hari_id)
                        ->first();

                    if ($checkJadwal) {
                        $fitness += 1;
                    }
                }
            }
        }

        $fitness = 1 / ($fitness + 1);
        return $fitness;
    }



    public function evaluatePopulation(Population $population)
    {
        $fitness = 0;
        $population->getIndividuals();

        foreach ($population->getIndividuals() as $individual) {
            $fitness += $this->calculateFitness($individual);
        }

        $population->setPopulationFitness($fitness);
    }

    public function isTerminationConditionMet($generation, $maxGenerations)
    {
        return $generation > $maxGenerations;
    }

    public function selectParent(Population $population)
    {
        $tournament = new Population($this->tournamentSize, $this->jadwal);

        $population->shuffle();
        for ($i = 0; $i < $this->tournamentSize; $i++) {
            $individual = $population->getIndividual($i);
            $tournament->setIndividual($i, $individual);
        }

        return $tournament->getFittest(0);
    }

    public function crossoverPopulation(Population $population)
    {
        $newPopulation = new Population($population->size(), $this->jadwal);

        for ($populationIndex = 0; $populationIndex < $population->size(); $populationIndex++) {
            $parent1 = $population->getFittest($populationIndex);

            if ($this->crossoverRate > rand(0, 100) && $populationIndex >= $this->elitismCount) {
                $parent2 = $this->selectParent($population);

                $child = new Individual($this->jadwal);

                $childJadwal = [];
                $parent1Jadwal = $parent1->getJadwal();
                $parent2Jadwal = $parent2->getJadwal();

                $crossOverPoint = rand(0, count($parent1Jadwal));

                for ($i = 0; $i < count($parent1Jadwal); $i++) {
                    if ($i < $crossOverPoint) {
                        $childJadwal[] = $parent1Jadwal[$i];
                    } else {
                        $childJadwal[] = $parent2Jadwal[$i];
                    }
                }

                $child->setJadwal($childJadwal);
                $newPopulation->setIndividual($populationIndex, $child);
            } else {
                $newPopulation->setIndividual($populationIndex, $parent1);
            }
        }

        return $newPopulation;
    }

    public function mutatePopulation(Population $population)
    {
        $newPopulation = new Population($population->size(), $this->jadwal);

        for ($populationIndex = 0; $populationIndex < $population->size(); $populationIndex++) {
            $individual = $population->getFittest($populationIndex);

            if ($populationIndex >= $this->elitismCount) {
                $individual = $this->mutate($individual);
            }

            $newPopulation->setIndividual($populationIndex, $individual);
        }

        return $newPopulation;
    }

    public function mutate(Individual $individual)
    {
        $newIndividual = new Individual($this->jadwal);

        $individualJadwal = $individual->getJadwal();
        $newIndividualJadwal = [];

        for ($jadwalIndex = 0; $jadwalIndex < count($individualJadwal); $jadwalIndex++) {
            if ($this->mutationRate > rand(0, 100)) {
                $newIndividualJadwal[$jadwalIndex] = $this->generateJadwal();
            } else {
                $newIndividualJadwal[$jadwalIndex] = $individualJadwal[$jadwalIndex];
            }
        }

        $newIndividual->setJadwal($newIndividualJadwal);
        return $newIndividual;
    }

    public function generateJadwal()
    {
        $jadwal = [];
        $kelas = $this->kelas->all();
        $ruangan = $this->ruangan->all();
        $jam = $this->jam->all();
        $hari = $this->hari->all();
        $pengampu = $this->pengampu->all();

        $kelasIndex = rand(0, count($kelas) - 1);
        $ruanganIndex = rand(0, count($ruangan) - 1);
        $jamIndex = rand(0, count($jam) - 1);
        $hariIndex = rand(0, count($hari) - 1);
        $pengampuIndex = rand(0, count($pengampu) - 1);

        $jadwal['kelas_id'] = $kelas[$kelasIndex]->id;
        $jadwal['ruangan_id'] = $ruangan[$ruanganIndex]->id;
        $jadwal['jam_id'] = $jam[$jamIndex]->id;
        $jadwal['hari_id'] = $hari[$hariIndex]->id;
        $jadwal['pengampu_id'] = $pengampu[$pengampuIndex]->id;

        return $jadwal;

    }

public function printPopulation(Population $population, $generation)
{
    echo "--------------------------------------------------\n";
    echo "Generation #{$generation} | Fittest chromosome fitness: {$population->getFittest(0)->getFitness()}\n";
    echo "--------------------------------------------------\n";

    $jadwal = $population->getFittest(0)->getJadwal();

    foreach ($jadwal as $key => $value) {
        $kelas = $this->getFirstWhere('kelas', 'id', $value['kelas_id']);
        $ruangan = $this->getFirstWhere('ruangan', 'id', $value['ruangan_id']);
        $jam = $this->getFirstWhere('jam', 'id', $value['jam_id']);
        $hari = $this->getFirstWhere('hari', 'id', $value['hari_id']);
        $pengampu = $this->getFirstWhere('pengampu', 'id', $value['pengampu_id']);

        $jam_waktu = $jam->waktu;
        $hari_nama = $hari->hari;
        $ruangan_nama = $ruangan->nama_ruangan;
        $kelas_nama = $kelas->nama_kelas;
        $pengampu_dosen = $pengampu->dosen_id;

        echo "Kelas: {$kelas_nama} | Ruangan: {$ruangan_nama} | Jam: {$jam_waktu} | Hari: {$hari_nama} | Pengampu: {$pengampu_dosen}\n";
    }
}

private function getFirstWhere($model, $column, $value)
{
    return $this->$model->where($column, $value)->first();
}


    // public function printPopulation(Population $population, $generation)
    // {
    //     echo "--------------------------------------------------\n";
    //     echo "Generation #{$generation} | Fittest chromosome fitness: {$population->getFittest(0)->getFitness()}\n";
    //     echo "--------------------------------------------------\n";

    //     $jadwal = $population->getFittest(0)->getJadwal();

    //     foreach ($jadwal as $key => $value) {
    //         $kelas_id = $value['kelas_id'];
    //         $ruangan_id = $value['ruangan_id'];
    //         $jam_id = $value['jam_id'];
    //         $hari_id = $value['hari_id'];
    //         $pengampu_id = $value['pengampu_id'];

    //         $kelas = $this->kelas->where('id', $kelas_id)->first();
    //         $ruangan = $this->ruangan->where('id', $ruangan_id)->first();
    //         $jam = $this->jam->where('id', $jam_id)->first();
    //         $hari = $this->hari->where('id', $hari_id)->first();
    //         $pengampu = $this->pengampu->where('id', $pengampu_id)->first();

    //         $jam = $jam->waktu;
    //         $hari = $hari->hari;
    //         $ruangan = $ruangan->nama_ruangan;
    //         $kelas = $kelas->nama_kelas;
    //         $pengampu = $pengampu->dosen_id;

    //         echo "Kelas: {$kelas} | Ruangan: {$ruangan} | Jam: {$jam} | Hari: {$hari} | Pengampu: {$pengampu}\n";
    //     }
    // }

    public function start()
    {
        $population = $this->initPopulation();
        $this->evaluatePopulation($population);

        $generation = 1;

        while (!$this->isTerminationConditionMet($generation, 100)) {
            $population = $this->crossoverPopulation($population);
            $population = $this->mutatePopulation($population);
            $this->evaluatePopulation($population);

            $this->printPopulation($population, $generation);

            $generation++;
        }
    }

    public function getFitness()
    {
        return $this->fitness;
    }

    public function setFitness($fitness)
    {
        $this->fitness = $fitness;
    }

    public function getPopulationSize()
    {
        return $this->populationSize;
    }

    public function setPopulationSize($populationSize)
    {
        $this->populationSize = $populationSize;
    }

    public function getMutationRate()
    {
        return $this->mutationRate;
    }
    public function setPopulationFitness($fitness)
{
    $this->populationFitness = $fitness;
}

public function getPopulationFitness()
{
    return $this->populationFitness;
}


}
