<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use App\Models\Jadwal;
use App\Genetik\GeneticAlgorithm;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jadwals = Jadwal::all();

        return view ('jadwal.index', compact('jadwals'));
    }

    /**
     * Show the form for creating a new resource.
     */


    public function generateSchedule(Request $request)
    {
        $populationSize = $request->input('population_size', 50); // Default to 50
        $maxGenerations = $request->input('max_generations', 100); // Default to 100

        // Run the genetic algorithm
        $ga = new GeneticAlgorithm();
        $bestSchedule = $ga->run($populationSize, $maxGenerations);

        return response()->json(['status' => 'finished']);
    }

    public function status()
    {
        // Check if there are any Jadwal records
        $isFinished = Jadwal::exists();
        $status = $isFinished ? 'finished' : 'processing';

        return response()->json(['status' => $status]);
    }
    /**
     * Display the specified resource.
     */
    public function show(Jadwal $jadwal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jadwal $jadwal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( $request, Jadwal $jadwal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jadwal $jadwal)
    {
        //
    }
}
=======
// use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class JadwalController extends Controller
{
    public function index()
    {
        // $jadwal = Kelas::all();
        // return view('kelas.index', compact('kelas'));
    }

}
>>>>>>> 865f0411564c207fe6f760c8faabef960c74ff14
