<?php

namespace App\Http\Controllers;

use App\Models\Pengampu;
use App\Models\Dosen;
use App\Models\Matkul;
use Illuminate\Http\Request;

class PengampuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()

    {
        $pengampus = Pengampu::all();
    $matkuls = Matkul::all()->keyBy('id');
    $dosens = Dosen::all();

        return view('pengampu.index',['pengampus' => $pengampus, 'matkuls' => $matkuls, 'dosens' => $dosens]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data
        $validatedData = $request->validate([
            'dosen_id' => 'required|unique:pengampu,dosen_id',
            'matkul_id' => 'required|array', // jika menggunakan multiple select
        ]);

        // Simpan data ke database
        $pengampu = new Pengampu();
        $pengampu->dosen_id = $validatedData['dosen_id'];
        // Jika menggunakan multiple select
        $pengampu->matkul_id = json_encode($validatedData['matkul_id']);
        $pengampu->save();

        return response()->json(['success' => 'Data berhasil disimpan']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengampu $pengampu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengampu $pengampu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( $request, Pengampu $pengampu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengampu $pengampu)
    {
        //
    }
}
