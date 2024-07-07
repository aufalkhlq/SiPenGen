<?php
namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Jam;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    // Fungsi untuk mengonversi string waktu ke format datetime
    private function convertTimeRange($timeRange) {
        list($start_time_str, $end_time_str) = explode(" - ", $timeRange);

        // Mengonversi waktu mulai dan waktu selesai
        $start_time = \DateTime::createFromFormat('H:i', $start_time_str);
        $end_time = \DateTime::createFromFormat('H:i', $end_time_str);

        if (!$start_time || !$end_time) {
            throw new \Exception("Invalid time format: $timeRange");
        }

        return array('start' => $start_time->format('H:i:s'), 'end' => $end_time->format('H:i:s'));
    }

    public function index(Request $request)
    {
        $jams = Jam::all();
        $user = Auth::guard('mahasiswa')->user();
        $kelasId = $user->kelas_id;
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $eventsByDay = [];

        foreach ($days as $day) {
            $eventsByDay[$day] = [];
            $jadwals = Jadwal::where('kelas_id', $kelasId)
                        ->whereHas('hari', function($query) use ($day) {
                            $query->where('hari', $day);
                        })
                        ->get();

            foreach ($jadwals as $jadwal) {
                try {
                    // Mengonversi waktu mulai dan waktu selesai
                    $convertedTimes = $this->convertTimeRange($jadwal->jam->waktu);

                    $eventsByDay[$day][] = [
                        'title' => $jadwal->pengampu->matkul->nama_matkul,
                        'start' => $convertedTimes['start'], // Waktu mulai
                        'end' => $convertedTimes['end'], // Waktu selesai
                        'ruangan' => $jadwal->ruangan->nama_ruangan
                    ];
                } catch (\Exception $e) {
                    \Log::error("Error converting time range: " . $e->getMessage());
                }
            }
        }

        return view('mahasiswa.jadwal.index', compact('eventsByDay', 'jams'));
    }
    
}
