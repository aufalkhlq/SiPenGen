<?php
namespace App\Genetik;

class Individual
{
    private $jadwal;
    private $fitness;

    public function __construct($jadwal)
    {
        $this->jadwal = $jadwal;
        $this->fitness = 0; // Nilai awal fitness dapat diatur sesuai kebutuhan
    }

    public function getJadwal()
    {
        return $this->jadwal;
    }

    public function getFitness()
    {
        return $this->fitness;
    }

    public function setFitness($fitness)
    {
        $this->fitness = $fitness;
    }

    public function setJadwal($jadwal)
    {
        $this->jadwal = $jadwal;
    }
}
