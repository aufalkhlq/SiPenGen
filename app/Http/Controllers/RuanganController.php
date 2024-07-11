<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ruangans = Ruangan::all();
        return view('admin.ruangan.index', compact('ruangans'));
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
        $request->validate([
            'nama_ruangan' => 'required',
            'kode_ruangan' => 'required',
            'kapasitas' => 'required|numeric',
            'lantai' => 'required',
        ]);
        //create new ruangan
        $ruangan = Ruangan::create([
            'nama_ruangan' => $request->nama_ruangan,
            'kode_ruangan' => $request->kode_ruangan,
            'kapasitas' => $request->kapasitas,
            'lantai' => $request->lantai,
        ]);

        return response()->json([
            'success' => 'Ruangan created successfully',
            'redirect' => route('ruangan'),
        ]);
    }

    /**
     * Display the specified resource.
     */

     public function show($id)
     {
         $ruangan = ruangan::find($id);

         // Return the ruangan data as JSON
         return response()->json($ruangan);
     }


    public function update(Request $request, Ruangan $ruangan)
    {
        $request->validate([
            'nama_ruangan' => 'required',
            'kode_ruangan' => 'required',
            'kapasitas' => 'required|numeric',
            'lantai' => 'required',
        ]);

        $ruangan->update([
            'nama_ruangan' => $request->nama_ruangan,
            'kode_ruangan' => $request->kode_ruangan,
            'kapasitas' => $request->kapasitas,
            'lantai' => $request->lantai,
        ]);

        return response()->json(['success' => 'Ruangan updated successfully']);
    }

    public function destroy(Ruangan $ruangan)
    {
        $ruangan->delete();
        return response()->json(['success' => 'Ruangan deleted successfully']);
    }
}
