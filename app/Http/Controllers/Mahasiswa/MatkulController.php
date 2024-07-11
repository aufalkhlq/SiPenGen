<?php
namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengampu;
use Illuminate\Support\Facades\Auth;

class MatkulController extends Controller
{
    public function index()
    {
        // Get the currently authenticated student
        $user = Auth::guard('mahasiswa')->user();
        $kelasId = $user->kelas_id;

        // Retrieve the courses and lecturers for the student's class
        $pengampus = Pengampu::with(['matkul', 'dosen'])
                             ->where('kelas_id', $kelasId)
                             ->get();

        return view('mahasiswa.matkul.index', compact('pengampus'));
    }
}
