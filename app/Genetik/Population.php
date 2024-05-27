<?php

namespace App\Genetik;

use Illuminate\Support\Collection;


class Population
{
    private $individuals;
    private $populationSize;


    public function __construct($populationSize, $jadwal)
    {
        $this->populationSize = $populationSize;
        $this->individuals = new Collection();

        if (!empty($jadwal)) {
            for ($i = 0; $i < $populationSize; $i++) {
                $individual = new Individual($jadwal);
                $this->individuals->push($individual);
            }
        }
    }


    public function getIndividuals()
    {
        return $this->individuals;
    }

    public function size()
    {
        return $this->populationSize;
    }

    public function getFittest($offset = 0)
    {
        $sorted = $this->individuals->sortByDesc(function ($individual) {
            return $individual->getFitness();
        });

        return $sorted->get($offset);
    }

    public function setIndividual($index, $individual)
    {
        $this->individuals[$index] = $individual;
    }

    public function shuffle()
    {
        $this->individuals = $this->individuals->shuffle();
    }
    public function setPopulationFitness($fitness)
    {
        if ($fitness !== null) {
            foreach ($this->individuals as $individual) {
                $individual->setFitness($fitness);
            }
        }
    }
    public function getIndividual($index)
    {
        if ($index >= 0 && $index < $this->populationSize) {
            return $this->individuals->get($index);
        }

        return null;
    }


}

