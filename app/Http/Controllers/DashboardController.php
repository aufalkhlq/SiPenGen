<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Matkul;
use App\Models\Ruangan;
use App\Models\Kelas;
use App\Models\Mahasiswa;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::count();
        $dosens = Dosen::count();
        $matkuls = Matkul::count();
        $ruangans = Ruangan::count();
        $mahasiswas = Mahasiswa::count();
        $kelas = Kelas::count();
        return view('admin.dashboard.index',compact('users','dosens','matkuls','ruangans','mahasiswas','kelas'));
    }

    public function dosen(){

        return view('dosen.dashboard.index');
    }
}
