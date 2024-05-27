<?php

namespace App\Http\Controllers\Genetik;

use App\Http\Controllers\Controller;
use App\Genetik\GeneticAlgorithm;
use App\Models\Kelas;
use App\Models\Pengampu;
use App\Models\Jadwal;
use App\Models\Ruangan;
use App\Models\Jam;
use App\Models\Hari;
use Illuminate\Http\Request;

class GenetikController extends Controller
{
    public function generateSchedule(Request $request)
    {
        $populationSize = $request->input('population_size', 50); // Default to 50
        $maxGenerations = $request->input('max_generations', 100); // Default to 100

        // Run the genetic algorithm
        $ga = new GeneticAlgorithm();
        $bestSchedule = $ga->run($populationSize, $maxGenerations);

        return redirect()->route('jadwal')->with('success', 'Jadwal berhasil di-generate!');
    }



}


