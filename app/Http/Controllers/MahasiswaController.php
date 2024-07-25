<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\Kelas;
use Illuminate\Support\Facades\Hash;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswas = Mahasiswa::all();
        $kelas = Kelas::all();
        return view('admin.mahasiswa.index', compact('mahasiswas', 'kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_mahasiswa' => 'required|string|max:255',
            'nim' => 'required|numeric|unique:mahasiswas',
            'prodi' => 'required|string|max:255',
            'kelas_id' => 'required|exists:kelas,id', // Validation for kelas_id
        ]);

        $mahasiswa = Mahasiswa::create([
            'nama_mahasiswa' => $request->nama_mahasiswa,
            'nim' => $request->nim,
            'prodi' => $request->prodi,
            'kelas_id' => $request->kelas_id, // Save kelas_id
            'password' => Hash::make('Polines2024'),
        ]);

        return response()->json(['success' => 'Mahasiswa added successfully.']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'edit-nama_mahasiswa' => 'required|string|max:255',
            'edit-nim' => 'required|numeric|unique:mahasiswas,nim,' . $id,
            'edit-prodi' => 'required|string|max:255',
            'edit-kelas_id' => 'required|exists:kelas,id', // Validation for kelas_id
        ]);

        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->update([
            'nama_mahasiswa' => $request->{'edit-nama_mahasiswa'},
            'nim' => $request->{'edit-nim'},
            'prodi' => $request->{'edit-prodi'},
            'kelas_id' => $request->{'edit-kelas_id'}, // Update kelas_id
        ]);

        if ($request->filled('edit-password')) {
            $mahasiswa->password = Hash::make($request->{'edit-password'});
            $mahasiswa->save();
        }

        return response()->json(['success' => 'Mahasiswa updated successfully.']);
    }

    public function edit(Mahasiswa $mahasiswa)
    {
        return response()->json($mahasiswa);
    }

    public function delete($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->delete();

        return response()->json(['success' => 'Mahasiswa deleted successfully.']);
    }
}
