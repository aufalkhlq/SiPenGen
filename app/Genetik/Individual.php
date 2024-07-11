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
    public function inisialisasiPopulasi($jumlahIndividu, $jumlahJam, $jumlahHari, $jumlahRuangan) {
        Log::info('Inisialisasi Populasi');
        $populasi = [];

        $pengampus = Pengampu::with(['matkul', 'kelas'])->get();
        $ruanganList = Ruangan::all()->toArray(); // Convert to array

        for ($i = 0; $i < $jumlahIndividu; $i++) {
            Log::info("Inisialisasi Individu", ['individu' => $i]);
            $individu = [];
            $jadwalMap = []; // Untuk cek konflik

            foreach ($pengampus as $pengampu) {
                Log::info("Inisialisasi Matkul", ['matkul' => $pengampu->matkul->id]);
                $matkul = $pengampu->matkul;
                $kelas = $pengampu->kelas;
                $sks = $matkul->sks;

                if ($sks <= 2) {
                    // Jadwalkan secara berurutan dalam satu hari
                    $this->buatJadwalBerurutan($jumlahHari, $jumlahJam, $jumlahRuangan, $kelas->id, $pengampu->id, $jadwalMap, $ruanganList, $individu, $sks);
                } else {
                    for ($s = 0; $s < $sks * 2; $s++) {
                        Log::info("Inisialisasi SKS Loop", ['loop' => $s]);
                        $attempts = 0;
                        $maxAttempts = 100; // Batasi jumlah percobaan
                        do {
                            $jadwal = $this->buatJadwal($jumlahHari, $jumlahJam, $jumlahRuangan, $kelas->id, $pengampu->id, $jadwalMap, $ruanganList);
                            $attempts++;
                        } while (!$jadwal && $attempts < $maxAttempts);

                        if ($jadwal) {
                            $individu[] = $jadwal;
                        } else {
                            Log::warning("Gagal inisialisasi jadwal setelah $maxAttempts percobaan untuk kelas " . $kelas->id . " matkul " . $matkul->id . " sks loop $s");
                        }
                    }
                }
            }

            $populasi[] = $individu;
        }

        return $populasi;
    }

    private function buatJadwalBerurutan($jumlahHari, $jumlahJam, $jumlahRuangan, $kelas_id, $pengampu_id, &$jadwalMap, $ruanganList, &$individu, $sks) {
        $hariList = range(1, $jumlahHari);
        shuffle($hariList);

        foreach ($hariList as $hari_id) {
            $jamList = range(1, $jumlahJam - ($sks - 1));
            shuffle($jamList);

            foreach ($jamList as $jam_id) {
                shuffle($ruanganList);

                foreach ($ruanganList as $ruangan) {
                    $ruangan_id = $ruangan['id'];
                    $kelasKey = $kelas_id . '-' . $jam_id . '-' . $hari_id;
                    $ruanganKey = $ruangan_id . '-' . $jam_id . '-' . $hari_id;
                    $pengampuKey = $pengampu_id . '-' . $jam_id . '-' . $hari_id;

                    if (!isset($jadwalMap[$kelasKey]) && !isset($jadwalMap[$ruanganKey]) && !isset($jadwalMap[$pengampuKey])) {
                        $jadwalBerurutan = true;
                        for ($s = 0; $s < $sks; $s++) {
                            $nextJam_id = $jam_id + $s;
                            if ($nextJam_id > $jumlahJam) {
                                $jadwalBerurutan = false;
                                break;
                            }

                            $kelasKey = $kelas_id . '-' . $nextJam_id . '-' . $hari_id;
                            $ruanganKey = $ruangan_id . '-' . $nextJam_id . '-' . $hari_id;
                            $pengampuKey = $pengampu_id . '-' . $nextJam_id . '-' . $hari_id;

                            if (isset($jadwalMap[$kelasKey]) || isset($jadwalMap[$ruanganKey]) || isset($jadwalMap[$pengampuKey])) {
                                $jadwalBerurutan = false;
                                break;
                            }
                        }

                        if ($jadwalBerurutan) {
                            for ($s = 0; $s < $sks; $s++) {
                                $nextJam_id = $jam_id + $s;

                                $jadwalMap[$kelas_id . '-' . $nextJam_id . '-' . $hari_id] = true;
                                $jadwalMap[$ruangan_id . '-' . $nextJam_id . '-' . $hari_id] = true;
                                $jadwalMap[$pengampu_id . '-' . $nextJam_id . '-' . $hari_id] = true;

                                $individu[] = [
                                    'kelas_id' => $kelas_id,
                                    'pengampu_id' => $pengampu_id,
                                    'ruangan_id' => $ruangan_id,
                                    'jam_id' => $nextJam_id,
                                    'hari_id' => $hari_id,
                                ];
                            }
                            return;
                        }
                    }
                }
            }
        }
    }

    private function buatJadwal($jumlahHari, $jumlahJam, $jumlahRuangan, $kelas_id, $pengampu_id, &$jadwalMap, $ruanganList) {
        $hariList = range(1, $jumlahHari);
        shuffle($hariList);

        foreach ($hariList as $hari_id) {
            $jamList = range(1, $jumlahJam);
            shuffle($jamList);

            foreach ($jamList as $jam_id) {
                if ($jam_id > $jumlahJam - 1) {
                    continue; // Pastikan jadwal tidak hanya 1 jam
                }

                shuffle($ruanganList);

                foreach ($ruanganList as $ruangan) {
                    $ruangan_id = $ruangan['id'];
                    $kelasKey = $kelas_id . '-' . $jam_id . '-' . $hari_id;
                    $ruanganKey = $ruangan_id . '-' . $jam_id . '-' . $hari_id;
                    $pengampuKey = $pengampu_id . '-' . $jam_id . '-' . $hari_id;

                    if (!isset($jadwalMap[$kelasKey]) && !isset($jadwalMap[$ruanganKey]) && !isset($jadwalMap[$pengampuKey])) {
                        $jadwalMap[$kelasKey] = true;
                        $jadwalMap[$ruanganKey] = true;
                        $jadwalMap[$pengampuKey] = true;

                        // Tambahkan jadwal untuk dua jam berturut-turut
                        $jadwalMap[$kelas_id . '-' . ($jam_id + 1) . '-' . $hari_id] = true;
                        $jadwalMap[$ruangan_id . '-' . ($jam_id + 1) . '-' . $hari_id] = true;
                        $jadwalMap[$pengampu_id . '-' . ($jam_id + 1) . '-' . $hari_id] = true;

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

    public function mutasi($individu, $jumlahJam, $jumlahHari, $jumlahRuangan, $ruanganList) {
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

                $jadwalBaru = $this->buatJadwal($jumlahHari, $jumlahJam, $jumlahRuangan, $kelas_id, $pengampu_id, $jadwalMap, $ruanganList);
                if ($jadwalBaru) {
                    $jadwal = $jadwalBaru;
                } else {
                    // Restore the previous entry if mutation fails
                    $jadwalMap[$jadwal['kelas_id'] . '-' . $jadwal['jam_id'] . '-' . $jadwal['hari_id']] = true;
                    $jadwalMap[$jadwal['ruangan_id'] . '-' . $jadwal['jam_id'] . '-' . $jadwal['hari_id']] = true;
                    $jadwalMap[$jadwal['pengampu_id'] . '-' . $jadwal['jam_id'] . '-' . $jadwal['hari_id']] = true;
                }
            }
        }
        return $individu;
    }

    public function mutasiPopulasi($populasi, $jumlahJam, $jumlahHari, $jumlahRuangan, $ruanganList) {
        Log::info('Mutasi Populasi');
        foreach ($populasi as &$individu) {
            $individu = $this->mutasi($individu, $jumlahJam, $jumlahHari, $jumlahRuangan, $ruanganList);
        }
        return $populasi;
    }

    public function algoritmaGenetik($jumlahGenerasi, $jumlahIndividu, $jumlahJam, $jumlahHari, $jumlahRuangan) {
        Log::info('Mulai Algoritma Genetik');
        $ruanganList = Ruangan::all()->toArray(); // Convert to array
        $populasi = $this->inisialisasiPopulasi($jumlahIndividu, $jumlahJam, $jumlahHari, $jumlahRuangan);

        for ($generasi = 0; $generasi < $jumlahGenerasi; $generasi++) {
            Log::info('Generasi', ['generasi' => $generasi]);
            $fitnessPopulasi = $this->evaluasiPopulasi($populasi);
            $populasiTerpilih = $this->seleksi($populasi, $fitnessPopulasi);
            $populasiBaru = $this->crossoverPopulasi($populasiTerpilih);

            if (!empty($populasiBaru)) {
                $populasi = $this->mutasiPopulasi($populasiBaru, $jumlahJam, $jumlahHari, $jumlahRuangan, $ruanganList);
            } else {
                // Jika populasi baru kosong, kembali ke populasi terpilih
                $populasi = $populasiTerpilih;
            }
        }

        $fitnessPopulasi = $this->evaluasiPopulasi($populasi);
        array_multisort($fitnessPopulasi, SORT_DESC, $populasi);

        Log::info('Algoritma Genetik Selesai');
        $jadwalTerbaik = !empty($populasi) ? $populasi[0] : [];

        // Simpan nilai fitness ke database
        if (!empty($jadwalTerbaik)) {
            $fitness = $this->evaluasiFitness($jadwalTerbaik);
            foreach ($jadwalTerbaik as &$jadwal) {
                $jadwal['fitness'] = $fitness;
            }
        }

        return $jadwalTerbaik;
    }

    public function simpanJadwal($jadwalTerbaik) {
        Log::info('Simpan Jadwal Terbaik');
        foreach ($jadwalTerbaik as $jadwal) {
            try {
                $kelasExists = Kelas::find($jadwal['kelas_id']);
                $pengampuExists = Pengampu::find($jadwal['pengampu_id']);
                $ruanganExists = Ruangan::find($jadwal['ruangan_id']);
                $jamExists = Jam::find($jadwal['jam_id']);
                $hariExists = Hari::find($jadwal['hari_id']);

                if ($kelasExists && $pengampuExists && $ruanganExists && $jamExists && $hariExists) {
                    Jadwal::create($jadwal);
                } else {
                    Log::warning('Foreign key constraint violation: ', $jadwal);
                }
            } catch (\Exception $e) {
                Log::error('Failed to save schedule: ' . $e->getMessage(), $jadwal);
            }
        }
    }
}
