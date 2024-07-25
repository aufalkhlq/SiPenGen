<?php
namespace App\Genetik;

use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Pengampu;
use App\Models\Ruangan;
use App\Models\Hari;
use App\Models\Jam;
use Illuminate\Support\Facades\Log;

ini_set('max_execution_time', 2000); // Set the maximum execution time to 5 minutes

class GeneticAlgorithm
{
    // Inisialisasi Populasi
    public function inisialisasiPopulasi($jumlahIndividu, $jumlahJam, $jumlahHari, $jumlahRuangan)
    {
        Log::info('Inisialisasi Populasi');
        $populasi = [];

        $pengampus = Pengampu::with('matkul', 'kelas')->get();

        for ($i = 0; $i < $jumlahIndividu; $i++) {
            Log::info("Inisialisasi Individu", ['individu' => $i]);
            $individu = [];
            $jadwalMap = [];
            $kelasJamPerHari = []; // Array to track hours per day per class

            foreach ($pengampus as $pengampu) {
                $kelas_id = $pengampu->kelas_id;
                Log::info("Inisialisasi Kelas", ['kelas' => $kelas_id]);
                $matkul = $pengampu->matkul;
                $sks = $matkul->sks;

                // Initialize jamPerHariKelas for this class
                if (!isset($kelasJamPerHari[$kelas_id])) {
                    $kelasJamPerHari[$kelas_id] = array_fill(1, $jumlahHari, 0);
                }

                // Calculate the total number of schedules needed for this matkul
                $totalJadwal = ceil($sks * 2); // 1 SKS = 2 hours, divided by 2 hours per schedule slot

                for ($s = 0; $s < $totalJadwal; $s++) {
                    Log::info("Inisialisasi SKS Loop", ['loop' => $s]);
                    $attempts = 0;
                    $maxAttempts = 100; // Batasi jumlah percobaan
                    do {
                        $jadwal = $this->buatJadwal($jumlahHari, $jumlahJam, $jumlahRuangan, $kelas_id, $pengampu->id, $matkul->nama_matkul, $jadwalMap, $kelasJamPerHari[$kelas_id]);
                        $attempts++;
                    } while (!$jadwal && $attempts < $maxAttempts);

                    if ($jadwal) {
                        $individu = array_merge($individu, $jadwal);
                    } else {
                        Log::warning("Gagal inisialisasi jadwal setelah $maxAttempts percobaan untuk kelas " . $kelas_id . " matkul " . $matkul->id . " sks loop $s");
                    }
                }
            }

            $populasi[] = $individu;
        }

        return $populasi;
    }

    // Membuat Jadwal
    private function buatJadwal($jumlahHari, $jumlahJam, $jumlahRuangan, $kelas_id, $pengampu_id, $matkulNama, &$jadwalMap, &$jamPerHariKelas)
    {
        for ($hari_id = 1; $hari_id <= $jumlahHari; $hari_id++) {
            if ($jamPerHariKelas[$hari_id] >= 8) {
                continue; // Skip if the daily limit of 8 hours is reached
            }

            for ($jam_id = 1; $jam_id <= $jumlahJam; $jam_id++) {
                if (!Jam::find($jam_id)) {
                    continue; // Skip if jam_id does not exist
                }

                for ($ruangan_id = 1; $ruangan_id <= $jumlahRuangan; $ruangan_id++) {
                    // Constraint for Jaringan Komputer I to be in room with ruangan_id = 8
                    if ($matkulNama == 'Jaringan Komputer I' && $ruangan_id != 8) {
                        continue; // Skip if it's not the specific room
                    }

                    $kelasKey = $kelas_id . '-' . $jam_id . '-' . $hari_id;
                    $ruanganKey = $ruangan_id . '-' . $jam_id . '-' . $hari_id;
                    $pengampuKey = $pengampu_id . '-' . $jam_id . '-' . $hari_id;

                    if (!isset($jadwalMap[$kelasKey]) && !isset($jadwalMap[$ruanganKey]) && !isset($jadwalMap[$pengampuKey])) {
                        $jadwalMap[$kelasKey] = true;
                        $jadwalMap[$ruanganKey] = true;
                        $jadwalMap[$pengampuKey] = true;
                        $jamPerHariKelas[$hari_id]++; // Increment the count of hours per day

                        return [
                            [
                                'kelas_id' => $kelas_id,
                                'pengampu_id' => $pengampu_id,
                                'ruangan_id' => $ruangan_id,
                                'jam_id' => $jam_id,
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
    public function evaluasiFitness($individu, $jumlahHari)
    {
        Log::info('Evaluasi Fitness Individu');
        $fitness = 0;
        $conflicts = 0;

        $jadwalMap = [];
        $kelasJamPerHari = []; // Array to track hours per day per class

        foreach ($individu as $jadwal) {
            $kelasKey = $jadwal['kelas_id'] . '-' . $jadwal['jam_id'] . '-' . $jadwal['hari_id'];
            $ruanganKey = $jadwal['ruangan_id'] . '-' . $jadwal['jam_id'] . '-' . $jadwal['hari_id'];
            $pengampuKey = $jadwal['pengampu_id'] . '-' . $jadwal['jam_id'] . '-' . $jadwal['hari_id'];

            // Track hours per day per class
            if (!isset($kelasJamPerHari[$jadwal['kelas_id']])) {
                $kelasJamPerHari[$jadwal['kelas_id']] = array_fill(1, $jumlahHari, 0);
            }
            $kelasJamPerHari[$jadwal['kelas_id']][$jadwal['hari_id']]++;

            // Cek konflik untuk setiap entri
            if (isset($jadwalMap[$kelasKey]) || isset($jadwalMap[$ruanganKey]) || isset($jadwalMap[$pengampuKey])) {
                $conflicts++;
                Log::info('Konflik ditemukan', ['kelasKey' => $kelasKey, 'ruanganKey' => $ruanganKey, 'pengampuKey' => $pengampuKey]);
            }

            $jadwalMap[$kelasKey] = true;
            $jadwalMap[$ruanganKey] = true;
            $jadwalMap[$pengampuKey] = true;
        }

        // Penalti jika melebihi batasan SKS dan jam per hari
        foreach ($kelasJamPerHari as $kelas_id => $jamPerHari) {
            foreach ($jamPerHari as $hari_id => $totalJam) {
                if ($totalJam > 8) {
                    $conflicts += ($totalJam - 8); // Tambahkan penalti untuk setiap jam melebihi 8 jam
                }
            }
        }

        $fitness = 1 / (1 + $conflicts); // Semakin sedikit konflik, semakin tinggi fitness

        return $fitness;
    }

    // Evaluasi Populasi
    public function evaluasiPopulasi($populasi, $jumlahHari)
    {
        Log::info('Evaluasi Fitness Populasi');
        $fitnessPopulasi = [];

        foreach ($populasi as $individu) {
            $fitnessPopulasi[] = $this->evaluasiFitness($individu, $jumlahHari);
        }

        return $fitnessPopulasi;
    }

    // Seleksi
    public function seleksi($populasi, $fitnessPopulasi)
    {
        Log::info('Seleksi Populasi');
        array_multisort($fitnessPopulasi, SORT_DESC, $populasi);
        $jumlahTerpilih = ceil(count($populasi) / 2);
        return array_slice($populasi, 0, $jumlahTerpilih);
    }

    // Crossover
    public function crossover($individu1, $individu2)
    {
        Log::info('Crossover');
        $titikPotong = rand(1, count($individu1) - 1);
        $anak1 = array_merge(array_slice($individu1, 0, $titikPotong), array_slice($individu2, $titikPotong));
        $anak2 = array_merge(array_slice($individu2, 0, $titikPotong), array_slice($individu1, $titikPotong));
        return [$anak1, $anak2];
    }

    // Crossover Populasi
    public function crossoverPopulasi($populasi)
    {
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
    public function mutasi($individu, $jumlahJam, $jumlahHari, $jumlahRuangan)
    {
        Log::info('Mutasi Individu');
        $probabilitasMutasi = 0.1;
        $jadwalMap = [];
        $kelasJamPerHari = []; // Array to track hours per day per class

        foreach ($individu as &$jadwal) {
            $jadwalMap[$jadwal['kelas_id'] . '-' . $jadwal['jam_id'] . '-' . $jadwal['hari_id']] = true;
            $jadwalMap[$jadwal['ruangan_id'] . '-' . $jadwal['jam_id'] . '-' . $jadwal['hari_id']] = true;
            $jadwalMap[$jadwal['pengampu_id'] . '-' . $jadwal['jam_id'] . '-' . $jadwal['hari_id']] = true;

            // Track hours per day per class
            if (!isset($kelasJamPerHari[$jadwal['kelas_id']])) {
                $kelasJamPerHari[$jadwal['kelas_id']] = array_fill(1, $jumlahHari, 0);
            }
            $kelasJamPerHari[$jadwal['kelas_id']][$jadwal['hari_id']]++;
        }

        foreach ($individu as &$jadwal) {
            if (rand(0, 100) / 100 < $probabilitasMutasi) {
                $kelas_id = $jadwal['kelas_id'];
                $pengampu_id = $jadwal['pengampu_id'];
                $matkulNama = Pengampu::find($pengampu_id)->matkul->nama_matkul;

                // Hapus entri jadwal lama
                unset($jadwalMap[$jadwal['kelas_id'] . '-' . $jadwal['jam_id'] . '-' . $jadwal['hari_id']]);
                unset($jadwalMap[$jadwal['ruangan_id'] . '-' . $jadwal['jam_id'] . '-' . $jadwal['hari_id']]);
                unset($jadwalMap[$jadwal['pengampu_id'] . '-' . $jadwal['jam_id'] . '-' . $jadwal['hari_id']]);

                $jadwalBaru = $this->buatJadwal($jumlahHari, $jumlahJam, $jumlahRuangan, $kelas_id, $pengampu_id, $matkulNama, $jadwalMap, $kelasJamPerHari[$kelas_id]);
                if ($jadwalBaru) {
                    $jadwal = $jadwalBaru[0];
                }
            }
        }
        return $individu;
    }

    // Mutasi Populasi
    public function mutasiPopulasi($populasi, $jumlahJam, $jumlahHari, $jumlahRuangan)
    {
        Log::info('Mutasi Populasi');
        foreach ($populasi as &$individu) {
            $individu = $this->mutasi($individu, $jumlahJam, $jumlahHari, $jumlahRuangan);
        }
        return $populasi;
    }

    // Algoritma Genetik Utama
    public function algoritmaGenetik($jumlahGenerasi, $jumlahIndividu, $jumlahJam, $jumlahHari, $jumlahRuangan)
    {
        Log::info('Mulai Algoritma Genetik');
        $populasi = $this->inisialisasiPopulasi($jumlahIndividu, $jumlahJam, $jumlahHari, $jumlahRuangan);
        $generasi = 0;
        $maxGenerasi = $jumlahGenerasi;
        $ambangBatasKonflik = 0; // Set your conflict threshold here

        do {
            Log::info('Generasi', ['generasi' => $generasi]);
            $fitnessPopulasi = $this->evaluasiPopulasi($populasi, $jumlahHari);
            $populasiTerpilih = $this->seleksi($populasi, $fitnessPopulasi);
            $populasiBaru = $this->crossoverPopulasi($populasiTerpilih);

            if (!empty($populasiBaru)) {
                $populasi = $this->mutasiPopulasi($populasiBaru, $jumlahJam, $jumlahHari, $jumlahRuangan);
            } else {
                $populasi = $populasiTerpilih;
            }

            $generasi++;
            $fitnessPopulasi = $this->evaluasiPopulasi($populasi, $jumlahHari);
            array_multisort($fitnessPopulasi, SORT_DESC, $populasi);
            $fitnessTerbaik = $fitnessPopulasi[0];

        } while ($generasi < $maxGenerasi && 1 / $fitnessTerbaik - 1 > $ambangBatasKonflik); // Check if the best fitness has acceptable conflicts

        Log::info('Algoritma Genetik Selesai');
        $jadwalTerbaik = !empty($populasi) ? $populasi[0] : [];

        if (!empty($jadwalTerbaik)) {
            $fitness = $this->evaluasiFitness($jadwalTerbaik, $jumlahHari);
            foreach ($jadwalTerbaik as &$jadwal) {
                $jadwal['fitness'] = $fitness;
            }
        }

        return $jadwalTerbaik;
    }

    // Simpan Jadwal
    public function simpanJadwal($jadwalTerbaik)
    {
        Log::info('Simpan Jadwal Terbaik');
        foreach ($jadwalTerbaik as $jadwal) {
            Jadwal::create($jadwal);
        }
    }
}
?>
