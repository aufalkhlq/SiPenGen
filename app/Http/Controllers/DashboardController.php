<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Matkul;
use App\Models\Ruangan;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::count();
        $dosens = Dosen::count();
        $matkuls = Matkul::count();
        $ruangans = Ruangan::count();
        return view('admin.dashboard.index',compact('users','dosens','matkuls','ruangans'));
    }

    public function dosen(){

        return view('dosen.dashboard.index');
    }
}
