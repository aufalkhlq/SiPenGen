<?php
namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengampu;
use Illuminate\Support\Facades\Auth;

class MatkulController extends Controller
{
    public function index()
    {
        // Get the currently authenticated lecturer
        $user = Auth::guard('dosen')->user();
        $dosenId = $user->id;

        // Retrieve the courses and classes the lecturer is teaching
        $pengampus = Pengampu::with(['matkul', 'dosen', 'kelas'])
                             ->where('dosen_id', $dosenId)
                             ->get();

        return view('dosen.matkul.index', compact('pengampus'));
    }
}
