<?php
namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Kelas;
use App\Genetik\GeneticAlgorithm;
use App\Models\Matkul;
use App\Models\Ruangan;
use App\Models\Hari;
use App\Models\Jam;
use Illuminate\Support\Facades\Log;
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
        $kelas = Kelas::all(); // Get all classes for the filter dropdown

        $conflicts = [];

        return view('admin.jadwal.index', [
            'jadwals' => $jadwals,
            'kelas' => $kelas,
            'selectedKelas' => $kelasId,
            'conflicts' => $conflicts
        ]);
    }

    public function generateSchedule() {
        try {
            $jumlahGenerasi = 100;
            $jumlahIndividu = 50;
            $jumlahJam = Jam::count();
            $jumlahHari = Hari::count();
            $jumlahRuangan = Ruangan::count();
            $jumlahKelas = Kelas::count(); // Dapatkan jumlah kelas
            $jumlahSksPerKelas = Matkul::sum('sks');

            $geneticAlgorithm = new GeneticAlgorithm();
            $jadwalTerbaik = $geneticAlgorithm->algoritmaGenetik(
                $jumlahGenerasi,
                $jumlahIndividu,
                $jumlahJam,
                $jumlahHari,
                $jumlahRuangan,
                $jumlahKelas,
                $jumlahSksPerKelas
            );

            if (!empty($jadwalTerbaik)) {
                $geneticAlgorithm->simpanJadwal($jadwalTerbaik);
            }

            return response()->json($jadwalTerbaik);

        } catch (\Exception $e) {
            Log::error('Error generating schedule: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function checkConflicts() {
        $conflicts = [];

        $jadwals = Jadwal::with(['pengampu.dosen', 'pengampu.matkul', 'ruangan', 'jam', 'hari', 'kelas'])->get();

        foreach ($jadwals as $jadwal1) {
            foreach ($jadwals as $jadwal2) {
                if ($jadwal1->id !== $jadwal2->id) {
                    if (
                        $jadwal1->jam_id === $jadwal2->jam_id &&
                        $jadwal1->hari_id === $jadwal2->hari_id &&
                        (
                            $jadwal1->ruangan_id === $jadwal2->ruangan_id ||
                            $jadwal1->pengampu_id === $jadwal2->pengampu_id ||
                            $jadwal1->kelas_id === $jadwal2->kelas_id
                        )
                    ) {
                        $conflicts[] = [
                            'kelas1' => $jadwal1->kelas->nama_kelas,
                            'hari1' => $jadwal1->hari->hari,
                            'dosen1' => $jadwal1->pengampu->dosen->nama_dosen,
                            'mata_kuliah1' => $jadwal1->pengampu->matkul->nama_matkul,
                            'ruangan1' => $jadwal1->ruangan->nama_ruangan,
                            'jam1' => $jadwal1->jam->waktu,
                            'kelas2' => $jadwal2->kelas->nama_kelas,
                            'hari2' => $jadwal2->hari->hari,
                            'dosen2' => $jadwal2->pengampu->dosen->nama_dosen,
                            'mata_kuliah2' => $jadwal2->pengampu->matkul->nama_matkul,
                            'ruangan2' => $jadwal2->ruangan->nama_ruangan,
                            'jam2' => $jadwal2->jam->waktu,
                            'type' => $jadwal1->ruangan_id === $jadwal2->ruangan_id ? 'Ruangan' : ($jadwal1->jam_id === $jadwal2->jam_id ? 'Jam' : 'Dosen/Kelas')
                        ];
                    }
                }
            }
        }

        return response()->json(['conflicts' => $conflicts]);
    }

    public function viewSchedule()
    {
        $geneticAlgorithm = new GeneticAlgorithm();
        $schedule = $geneticAlgorithm->getSchedule();

        return response()->json(['schedule' => $schedule]);
    }

    public function status()
    {
        // Check if there are any Jadwal records
        $isFinished = Jadwal::exists();
        $status = $isFinished ? 'finished' : 'processing';

        return response()->json(['status' => $status]);
    }

    public function getSchedule()
    {
        $geneticAlgorithm = new GeneticAlgorithm();
        $schedule = $geneticAlgorithm->getSchedule();

        return response()->json($schedule);
    }
}
