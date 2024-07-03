<?php

namespace App\Http\Controllers\Mahasiswa;
use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Services\ScheduleGenerator;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $kelasId = $request->input('kelas_id');
        $jadwals = Jadwal::with(['pengampu.dosen', 'pengampu.matkul', 'ruangan', 'jam', 'hari', 'kelas']);

        if (!empty($kelasId)) {
            $jadwals = $jadwals->where('kelas_id', $kelasId);
        }

        $jadwals = $jadwals->get();
        $kelas = Kelas::all();

        return view('mahasiswa.jadwal.index', [
            'jadwals' => $jadwals,
            'kelas' => $kelas,
            'selectedKelas' => $kelasId
        ]);
    }

    public function generateSchedule()
    {
        $generator = new ScheduleGenerator();
        $bestSchedule = $generator->generate();
        return response()->json([
            'message' => 'Schedule generation completed successfully.',
            'schedule' => $bestSchedule
        ]);
    }

    public function viewSchedule()
    {
        $generator = new ScheduleGenerator();
        $schedule = $generator->generate();
        return response()->json(['schedule' => $schedule]);
    }

    public function status()
    {
        $isFinished = Jadwal::exists();
        $status = $isFinished ? 'finished' : 'processing';

        return response()->json(['status' => $status]);
    }

    public function getSchedule()
    {
        $generator = new ScheduleGenerator();
        $schedule = $generator->generate();
        return response()->json($schedule);
    }
}
