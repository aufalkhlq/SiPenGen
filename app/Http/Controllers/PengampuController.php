<?php
namespace App\Http\Controllers;

use App\Models\Pengampu;
use App\Models\Dosen;
use App\Models\Matkul;
use App\Models\Kelas; // Add this line
use Illuminate\Http\Request;

class PengampuController extends Controller
{
    public function index()
    {
        $pengampus = Pengampu::all();
        $matkuls = Matkul::all();
        $dosens = Dosen::all();
        $kelas = Kelas::all(); // Add this line

        return view('admin.pengampu.index', [
            'pengampus' => $pengampus,
            'matkuls' => $matkuls,
            'dosens' => $dosens,
            'kelas' => $kelas, // Add this line
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'dosen_id' => 'required',
            'matkul_id' => 'required',
            'kelas_id' => 'required', // Add this line
        ]);

        $pengampu = new Pengampu();
        $pengampu->dosen_id = $validatedData['dosen_id'];
        $pengampu->matkul_id = $validatedData['matkul_id'];
        $pengampu->kelas_id = $validatedData['kelas_id']; // Add this line
        $pengampu->save();

        return response()->json(['success' => 'Data berhasil disimpan']);
    }

    public function edit($id)
    {
        $pengampu = Pengampu::find($id);

        return response()->json($pengampu);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'dosen_id' => 'required',
            'matkul_id' => 'required',
            'kelas_id' => 'required', // Add this line
        ]);

        $pengampu = Pengampu::find($id);
        $pengampu->dosen_id = $validatedData['dosen_id'];
        $pengampu->matkul_id = $validatedData['matkul_id'];
        $pengampu->kelas_id = $validatedData['kelas_id']; // Add this line
        $pengampu->save();

        return response()->json(['success' => 'Data berhasil diperbarui']);
    }
    public function delete($id)
    {
        try {
            $pengampu = Pengampu::findOrFail($id);
            $pengampu->delete();
            return response()->json(['success' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menghapus data'], 500);
        }
    }
    public function deleteAll()
    {
        Pengampu::truncate();

        return response()->json(['success' => 'All records deleted successfully.']);
    }

}
