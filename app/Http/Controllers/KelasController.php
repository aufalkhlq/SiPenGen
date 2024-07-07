<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelas = Kelas::all();
        return view('admin.kelas.index', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required',
            'tahun_angkatan' => 'required|numeric',
            'prodi' => 'required',
        ]);

        //create new kelas
        Kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'tahun_angkatan' => $request->tahun_angkatan,
            'prodi' => $request->prodi,
        ]);

        return response()->json([
            'success' => 'Kelas created successfully',
            'redirect' => route('kelas'),
        ]);
    }

    public function edit($id)
    {
        $kelas = Kelas::find($id);
        return response()->json($kelas);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kelas' => 'required',
            'tahun_angkatan' => 'required|numeric',
            'prodi' => 'required',
        ]);

        $kelas = Kelas::find($id);

        $kelas->nama_kelas = $request->nama_kelas;
        $kelas->tahun_angkatan = $request->tahun_angkatan;
        $kelas->prodi = $request->prodi;

        $kelas->save();

        return response()->json([
            'success' => 'Kelas updated successfully',
        ]);
    }

    public function destroy($id)
    {
        Kelas::destroy($id);

        return response()->json([
            'success' => 'Kelas deleted successfully',
        ]);
    }
}
