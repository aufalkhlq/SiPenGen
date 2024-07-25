<?php
namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    public function index()
    {
        $ruangans = Ruangan::all();
        return view('admin.ruangan.index', compact('ruangans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_ruangan' => 'required|unique:ruangan',
            'kode_ruangan' => 'required',
            'kapasitas' => 'required|numeric',
            'lantai' => 'required',
        ]);

        $ruangan = Ruangan::create([
            'nama_ruangan' => $request->nama_ruangan,
            'kode_ruangan' => $request->kode_ruangan,
            'kapasitas' => $request->kapasitas,
            'lantai' => $request->lantai,
        ]);

        return response()->json([
            'success' => 'Ruangan created successfully',
        ]);
    }

    public function show($id)
    {
        $ruangan = Ruangan::findOrFail($id);
        return response()->json($ruangan);
    }

    public function update(Request $request, Ruangan $ruangan)
    {
        $request->validate([
            'nama_ruangan' => 'required|unique:ruangan,nama_ruangan,' . $ruangan->id,
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
