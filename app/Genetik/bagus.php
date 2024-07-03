<?php
namespace App\Genetik;

use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Pengampu;
use App\Models\Ruangan;
use App\Models\Hari;
use App\Models\Jam;
use Illuminate\Support\Facades\Log;

class GeneticAlgorithm
{
    public function inisialisasiPopulasi($jumlahIndividu, $jumlahKelas, $jumlahMatkul, $jumlahJam, $jumlahHari, $jumlahRuangan) {
        Log::info('Inisialisasi Populasi');
        $populasi = [];

        for ($i = 0; $i < $jumlahIndividu; $i++) {
            Log::info("Inisialisasi Individu", ['individu' => $i]);
            $individu = [];
            $jadwalMap = []; // Untuk cek konflik

            for ($j = 0; $j < $jumlahKelas; $j++) {
                Log::info("Inisialisasi Kelas", ['kelas' => $j]);
                for ($k = 0; $k < $jumlahMatkul; $k++) {
                    Log::info("Inisialisasi Matkul", ['matkul' => $k]);
                    $matkul = Pengampu::find($k + 1)->matkul;
                    $sks = $matkul->sks;

                    for ($s = 0; $s < $sks; $s++) {
                        Log::info("Inisialisasi SKS Loop", ['loop' => $s]);
                        $attempts = 0;
                        $maxAttempts = 100; // Batasi jumlah percobaan
                        do {
                            $jadwal = $this->buatJadwal($jumlahHari, $jumlahJam, $jumlahRuangan, $j + 1, $k + 1, $jadwalMap);
                            $attempts++;
                        } while (!$jadwal && $attempts < $maxAttempts);

                        if ($jadwal) {
                            $individu[] = $jadwal;
                        } else {
                            Log::warning("Gagal inisialisasi jadwal setelah $maxAttempts percobaan");
                        }
                    }
                }
            }

            $populasi[] = $individu;
        }

        return $populasi;
    }

    private function buatJadwal($jumlahHari, $jumlahJam, $jumlahRuangan, $kelas_id, $pengampu_id, &$jadwalMap) {
        for ($hari_id = 1; $hari_id <= $jumlahHari; $hari_id++) {
            for ($jam_id = 1; $jam_id <= $jumlahJam; $jam_id++) {
                for ($ruangan_id = 1; $ruangan_id <= $jumlahRuangan; $ruangan_id++) {
                    $kelasKey = $kelas_id . '-' . $jam_id . '-' . $hari_id;
                    $ruanganKey = $ruangan_id . '-' . $jam_id . '-' . $hari_id;
                    $pengampuKey = $pengampu_id . '-' . $jam_id . '-' . $hari_id;

                    if (!isset($jadwalMap[$kelasKey]) && !isset($jadwalMap[$ruanganKey]) && !isset($jadwalMap[$pengampuKey])) {
                        $jadwalMap[$kelasKey] = true;
                        $jadwalMap[$ruanganKey] = true;
                        $jadwalMap[$pengampuKey] = true;
                        return [
                            'kelas_id' => $kelas_id,
                            'pengampu_id' => $pengampu_id,
                            'ruangan_id' => $ruangan_id,
                            'jam_id' => $jam_id,
                            'hari_id' => $hari_id,
                        ];
                    }
                }
            }
        }
        return null;
    }

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
            }

            $jadwalMap[$kelasKey] = true;
            $jadwalMap[$ruanganKey] = true;
            $jadwalMap[$pengampuKey] = true;
        }

        $fitness = 1 / (1 + $conflicts); // Semakin sedikit konflik, semakin tinggi fitness

        return $fitness;
    }

    public function evaluasiPopulasi($populasi) {
        Log::info('Evaluasi Fitness Populasi');
        $fitnessPopulasi = [];

        foreach ($populasi as $individu) {
            $fitnessPopulasi[] = $this->evaluasiFitness($individu);
        }

        return $fitnessPopulasi;
    }

    public function seleksi($populasi, $fitnessPopulasi) {
        Log::info('Seleksi Populasi');
        array_multisort($fitnessPopulasi, SORT_DESC, $populasi);
        $jumlahTerpilih = ceil(count($populasi) / 2);
        return array_slice($populasi, 0, $jumlahTerpilih);
    }

    public function crossover($individu1, $individu2) {
        Log::info('Crossover');
        $titikPotong = rand(1, count($individu1) - 1);
        $anak1 = array_merge(array_slice($individu1, 0, $titikPotong), array_slice($individu2, $titikPotong));
        $anak2 = array_merge(array_slice($individu2, 0, $titikPotong), array_slice($individu1, $titikPotong));
        return [$anak1, $anak2];
    }

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
                    $jadwal = $jadwalBaru;
                }
            }
        }
        return $individu;
    }

    public function mutasiPopulasi($populasi, $jumlahJam, $jumlahHari, $jumlahRuangan) {
        Log::info('Mutasi Populasi');
        foreach ($populasi as &$individu) {
            $individu = $this->mutasi($individu, $jumlahJam, $jumlahHari, $jumlahRuangan);
        }
        return $populasi;
    }

    public function algoritmaGenetik($jumlahGenerasi, $jumlahIndividu, $jumlahKelas, $jumlahMatkul, $jumlahJam, $jumlahHari, $jumlahRuangan) {
        Log::info('Mulai Algoritma Genetik');
        $populasi = $this->inisialisasiPopulasi($jumlahIndividu, $jumlahKelas, $jumlahMatkul, $jumlahJam, $jumlahHari, $jumlahRuangan);

        for ($generasi = 0; $generasi < $jumlahGenerasi; $generasi++) {
            Log::info('Generasi', ['generasi' => $generasi]);
            $fitnessPopulasi = $this->evaluasiPopulasi($populasi);
            $populasiTerpilih = $this->seleksi($populasi, $fitnessPopulasi);
            $populasiBaru = $this->crossoverPopulasi($populasiTerpilih);

            if (!empty($populasiBaru)) {
                $populasi = $this->mutasiPopulasi($populasiBaru, $jumlahJam, $jumlahHari, $jumlahRuangan);
            } else {
                // Jika populasi baru kosong, kembali ke populasi terpilih
                $populasi = $populasiTerpilih;
            }
        }

        $fitnessPopulasi = $this->evaluasiPopulasi($populasi);
        array_multisort($fitnessPopulasi, SORT_DESC, $populasi);

        Log::info('Algoritma Genetik Selesai');
        return !empty($populasi) ? $populasi[0] : [];
    }

    public function simpanJadwal($jadwalTerbaik) {
        Log::info('Simpan Jadwal Terbaik');
        foreach ($jadwalTerbaik as $jadwal) {
            Jadwal::create($jadwal);
        }
    }
}
