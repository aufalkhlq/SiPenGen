<?php
namespace App\Genetik;

use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Pengampu;
use App\Models\Ruangan;
use Illuminate\Support\Facades\Log;
ini_set('max_execution_time', 2000); // Set the maximum execution time to 5 minutes

class GeneticAlgorithm
{
    // Inisialisasi Populasi
    public function inisialisasiPopulasi($jumlahIndividu, $jumlahJam, $jumlahHari, $jumlahRuangan) {
        Log::info('Inisialisasi Populasi');
        $populasi = [];
        $pengampus = Pengampu::with('matkul', 'kelas')->get();

        for ($i = 0; $i < $jumlahIndividu; $i++) {
            Log::info("Inisialisasi Individu", ['individu' => $i]);
            $individu = [];
            $jadwalMap = [];

            foreach ($pengampus as $pengampu) {
                $kelas_id = $pengampu->kelas_id;
                Log::info("Inisialisasi Kelas", ['kelas' => $kelas_id]);
                $matkul = $pengampu->matkul;
                $sks = $matkul->sks;

                // Adjust session based on SKS
                if ($sks == 1) {
                    $jadwal = $this->createConsecutiveSessions($jumlahHari, $jumlahJam, $jumlahRuangan, $kelas_id, $pengampu->id, $jadwalMap, 2);
                    if ($jadwal) {
                        $individu = array_merge($individu, $jadwal);
                    }
                } else if ($sks == 2) {
                    $jadwal = $this->createConsecutiveSessions($jumlahHari, $jumlahJam, $jumlahRuangan, $kelas_id, $pengampu->id, $jadwalMap, 2);
                    if ($jadwal) {
                        $individu = array_merge($individu, $jadwal);
                    }
                } else if ($sks == 3) {
                    $jadwal = $this->createConsecutiveSessions($jumlahHari, $jumlahJam, $jumlahRuangan, $kelas_id, $pengampu->id, $jadwalMap, 3);
                    if ($jadwal) {
                        $individu = array_merge($individu, $jadwal);
                    }
                }
            }

            $populasi[] = $individu;
        }

        return $populasi;
    }

    // Function to create consecutive sessions based on SKS
    private function createConsecutiveSessions($jumlahHari, $jumlahJam, $jumlahRuangan, $kelas_id, $pengampu_id, &$jadwalMap, $requiredHours) {
        $sessions = [];
        for ($hari_id = 1; $hari_id <= $jumlahHari; $hari_id++) {
            for ($jam_id = 1; $jam_id <= $jumlahJam - ($requiredHours - 1); $jam_id++) {
                $canSchedule = true;
                for ($offset = 0; $offset < $requiredHours; $offset++) {
                    $key = $kelas_id . '-' . ($jam_id + $offset) . '-' . $hari_id;
                    if (isset($jadwalMap[$key])) {
                        $canSchedule = false;
                        break;
                    }
                }

                if ($canSchedule) {
                    for ($offset = 0; $offset < $requiredHours; $offset++) {
                        $jamCurrent = $jam_id + $offset;
                        $key = $kelas_id . '-' . $jamCurrent . '-' . $hari_id;
                        $sessions[] = [
                            'kelas_id' => $kelas_id,
                            'pengampu_id' => $pengampu_id,
                            'ruangan_id' => rand(1, $jumlahRuangan), // Randomly assign a room
                            'jam_id' => $jamCurrent,
                            'hari_id' => $hari_id,
                        ];
                        $jadwalMap[$key] = true; // Mark this slot as taken
                    }
                    return $sessions;
                }
            }
        }
        return null; // No suitable schedule found
    }

    // Membuat Jadwal
    private function buatJadwal($jumlahHari, $jumlahJam, $jumlahRuangan, $kelas_id, $pengampu_id, &$jadwalMap) {
        for ($hari_id = 1; $hari_id <= $jumlahHari; $hari_id++) {
            for ($jam_id = 1; $jam_id <= $jumlahJam - 1; $jam_id++) {
                for ($ruangan_id = 1; $ruangan_id <= $jumlahRuangan; $ruangan_id++) {
                    $kelasKey = $kelas_id . '-' . $jam_id . '-' . $hari_id;
                    $kelasKeyNext = $kelas_id . '-' . ($jam_id + 1) . '-' . $hari_id;
                    $ruanganKey = $ruangan_id . '-' . $jam_id . '-' . $hari_id;
                    $ruanganKeyNext = $ruangan_id . '-' . ($jam_id + 1) . '-' . $hari_id;
                    $pengampuKey = $pengampu_id . '-' . $jam_id . '-' . $hari_id;
                    $pengampuKeyNext = $pengampu_id . '-' . ($jam_id + 1) . '-' . $hari_id;

                    if (!isset($jadwalMap[$kelasKey]) && !isset($jadwalMap[$ruanganKey]) && !isset($jadwalMap[$pengampuKey]) &&
                        !isset($jadwalMap[$kelasKeyNext]) && !isset($jadwalMap[$ruanganKeyNext]) && !isset($jadwalMap[$pengampuKeyNext])) {

                        $jadwalMap[$kelasKey] = true;
                        $jadwalMap[$ruanganKey] = true;
                        $jadwalMap[$pengampuKey] = true;
                        $jadwalMap[$kelasKeyNext] = true;
                        $jadwalMap[$ruanganKeyNext] = true;
                        $jadwalMap[$pengampuKeyNext] = true;

                        return [
                            [
                                'kelas_id' => $kelas_id,
                                'pengampu_id' => $pengampu_id,
                                'ruangan_id' => $ruangan_id,
                                'jam_id' => $jam_id,
                                'hari_id' => $hari_id,
                            ],
                            [
                                'kelas_id' => $kelas_id,
                                'pengampu_id' => $pengampu_id,
                                'ruangan_id' => $ruangan_id,
                                'jam_id' => $jam_id + 1,
                                'hari_id' => $hari_id,
                            ]
                        ];
                    }
                }
            }
        }
        return null;
    }

    // Evaluasi Fitness
    public function evaluasiFitness($individu) {
        Log::info('Evaluasi Fitness Individu');
        $fitness = 0;
        $conflicts = 0;

        $jadwalMap = [];

        foreach ($individu as $jadwal) {
            $kelasKey = $jadwal['kelas_id'] . '-' . $jadwal['jam_id'] . '-' . $jadwal['hari_id'];
            $ruanganKey = $jadwal['ruangan_id'] . '-' . $jadwal['jam_id'] . '-' . $jadwal['hari_id'];
            $pengampuKey = $jadwal['pengampu_id'] . '-' . $jadwal['jam_id'] . '-' . $jadwal['hari_id'];

            // Cek konflik untuk setiap entri
            if (isset($jadwalMap[$kelasKey]) || isset($jadwalMap[$ruanganKey]) || isset($jadwalMap[$pengampuKey])) {
                $conflicts++;
                Log::info('Konflik ditemukan', ['kelasKey' => $kelasKey, 'ruanganKey' => $ruanganKey, 'pengampuKey' => $pengampuKey]);
            }

            // Cek waktu istirahat yang tidak mencukupi (misalnya 1 jam istirahat setelah 3 jam berturut-turut)
            if ($jadwal['jam_id'] == 4 || $jadwal['jam_id'] == 8) {
                $conflicts++;
                Log::info('Konflik waktu istirahat', ['jam_id' => $jadwal['jam_id']]);
            }

            // Preferensi dosen (misalnya dosen tidak tersedia pada jam atau hari tertentu)
            // Logika untuk preferensi dosen dapat ditambahkan di sini

            $jadwalMap[$kelasKey] = true;
            $jadwalMap[$ruanganKey] = true;
            $jadwalMap[$pengampuKey] = true;
        }

        $fitness = 1 / (1 + $conflicts); // Semakin sedikit konflik, semakin tinggi fitness

        return $fitness;
    }

    // Evaluasi Populasi
    public function evaluasiPopulasi($populasi) {
        Log::info('Evaluasi Fitness Populasi');
        $fitnessPopulasi = [];

        foreach ($populasi as $individu) {
            $fitnessPopulasi[] = $this->evaluasiFitness($individu);
        }

        return $fitnessPopulasi;
    }

    // Seleksi
    public function seleksi($populasi, $fitnessPopulasi) {
        Log::info('Seleksi Populasi');
        array_multisort($fitnessPopulasi, SORT_DESC, $populasi);
        $jumlahTerpilih = ceil(count($populasi) / 2);
        return array_slice($populasi, 0, $jumlahTerpilih);
    }

    // Crossover
    public function crossover($individu1, $individu2) {
        Log::info('Crossover');
        $titikPotong = rand(1, count($individu1) - 1);
        $anak1 = array_merge(array_slice($individu1, 0, $titikPotong), array_slice($individu2, $titikPotong));
        $anak2 = array_merge(array_slice($individu2, 0, $titikPotong), array_slice($individu1, $titikPotong));
        return [$anak1, $anak2];
    }

    // Crossover Populasi
    public function crossoverPopulasi($populasi) {
        Log::info('Crossover Populasi');
        $populasiBaru = [];
        for ($i = 0; $i < count($populasi) - 1; $i += 2) {
            $anak = $this->crossover($populasi[$i], $populasi[$i + 1]);
            $populasiBaru[] = $anak[0];
            $populasiBaru[] = $anak[1];
        }
        return $populasiBaru;
    }

    // Mutasi
    public function mutasi($individu, $jumlahJam, $jumlahHari, $jumlahRuangan) {
        Log::info('Mutasi Individu');
        $probabilitasMutasi = 0.1;
        $jadwalMap = [];
        foreach ($individu as &$jadwal) {
            $jadwalMap[$jadwal['kelas_id'] . '-' . $jadwal['jam_id'] . '-' . $jadwal['hari_id']] = true;
            $jadwalMap[$jadwal['ruangan_id'] . '-' . $jadwal['jam_id'] . '-' . $jadwal['hari_id']] = true;
            $jadwalMap[$jadwal['pengampu_id'] . '-' . $jadwal['jam_id'] . '-' . $jadwal['hari_id']] = true;
        }

        foreach ($individu as &$jadwal) {
            if (rand(0, 100) / 100 < $probabilitasMutasi) {
                $kelas_id = $jadwal['kelas_id'];
                $pengampu_id = $jadwal['pengampu_id'];

                // Hapus entri jadwal lama
                unset($jadwalMap[$jadwal['kelas_id'] . '-' . $jadwal['jam_id'] . '-' . $jadwal['hari_id']]);
                unset($jadwalMap[$jadwal['ruangan_id'] . '-' . $jadwal['jam_id'] . '-' . $jadwal['hari_id']]);
                unset($jadwalMap[$jadwal['pengampu_id'] . '-' . $jadwal['jam_id'] . '-' . $jadwal['hari_id']]);

                $jadwalBaru = $this->buatJadwal($jumlahHari, $jumlahJam, $jumlahRuangan, $kelas_id, $pengampu_id, $jadwalMap);
                if ($jadwalBaru) {
                    $jadwal = $jadwalBaru[0];
                }
            }
        }
        return $individu;
    }

    // Mutasi Populasi
    public function mutasiPopulasi($populasi, $jumlahJam, $jumlahHari, $jumlahRuangan) {
        Log::info('Mutasi Populasi');
        foreach ($populasi as &$individu) {
            $individu = $this->mutasi($individu, $jumlahJam, $jumlahHari, $jumlahRuangan);
        }
        return $populasi;
    }

    // Algoritma Genetik Utama
    public function algoritmaGenetik($jumlahGenerasi, $jumlahIndividu, $jumlahJam, $jumlahHari, $jumlahRuangan) {
        Log::info('Mulai Algoritma Genetik');
        $populasi = $this->inisialisasiPopulasi($jumlahIndividu, $jumlahJam, $jumlahHari, $jumlahRuangan);

        $jadwalTerbaik = [];
        $fitnessTerbaik = 0;

        for ($generasi = 0; $generasi < $jumlahGenerasi; $generasi++) {
            Log::info('Generasi', ['generasi' => $generasi]);
            $fitnessPopulasi = $this->evaluasiPopulasi($populasi);
            $populasiTerpilih = $this->seleksi($populasi, $fitnessPopulasi);
            $populasiBaru = $this->crossoverPopulasi($populasiTerpilih);

            if (!empty($populasiBaru)) {
                $populasi = $this->mutasiPopulasi($populasiBaru, $jumlahJam, $jumlahHari, $jumlahRuangan);
            } else {
                $populasi = $populasiTerpilih;
            }

            // Update jadwal terbaik
            $fitnessPopulasi = $this->evaluasiPopulasi($populasi);
            array_multisort($fitnessPopulasi, SORT_DESC, $populasi);

            if ($fitnessPopulasi[0] > $fitnessTerbaik) {
                $fitnessTerbaik = $fitnessPopulasi[0];
                $jadwalTerbaik = $populasi[0];
            }
        }

        // Proses kembali individu yang masih memiliki konflik
        $maksimumIterasi = 1000; // batas iterasi maksimum
        $iterasi = 0;
        while ($fitnessTerbaik < 1 && $iterasi < $maksimumIterasi) {
            Log::info('Mengolah kembali jadwal dengan konflik', ['iterasi' => $iterasi]);
            $fitnessPopulasi = $this->evaluasiPopulasi($populasi);
            $populasiTerpilih = $this->seleksi($populasi, $fitnessPopulasi);
            $populasiBaru = $this->crossoverPopulasi($populasiTerpilih);

            if (!empty($populasiBaru)) {
                $populasi = $this->mutasiPopulasi($populasiBaru, $jumlahJam, $jumlahHari, $jumlahRuangan);
            } else {
                $populasi = $populasiTerpilih;
            }

            array_multisort($fitnessPopulasi, SORT_DESC, $populasi);
            if ($fitnessPopulasi[0] > $fitnessTerbaik) {
                $fitnessTerbaik = $fitnessPopulasi[0];
                $jadwalTerbaik = $populasi[0];
            }
            $iterasi++;
        }

        // Simpan jadwal terbaik yang ditemukan
        $this->simpanJadwal($jadwalTerbaik);

        if ($fitnessTerbaik < 1) {
            Log::warning('Tidak ada jadwal yang sempurna (fitness = 1) ditemukan setelah batas iterasi maksimum. Jadwal terbaik yang ditemukan disimpan dengan fitness = ' . $fitnessTerbaik);
        }

        return $jadwalTerbaik;
    }

    // Simpan Jadwal
    public function simpanJadwal($jadwalTerbaik) {
        Log::info('Simpan Jadwal Terbaik');
        foreach ($jadwalTerbaik as $jadwal) {
            Jadwal::create($jadwal);
        }
    }
}
?>
