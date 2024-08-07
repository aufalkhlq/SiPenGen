<?php
namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Kelas;
use App\Genetik\GeneticAlgorithm;
use App\Models\Matkul;
use App\Models\Ruangan;
use App\Models\Hari;
use App\Models\Jam;
use App\Models\Dosen;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;


class JadwalController extends Controller
{
    protected $geneticAlgorithm;

    public function __construct(GeneticAlgorithm $geneticAlgorithm)
    {
        $this->geneticAlgorithm = $geneticAlgorithm;
    }
    private function getConflicts()
    {
        $conflicts = [];
        $jadwals = Jadwal::with(['pengampu.dosen', 'pengampu.matkul', 'ruangan', 'jam', 'hari', 'kelas'])->get();

        // Kelompokkan jadwal berdasarkan hari dan jam
        $groupedJadwals = $jadwals->groupBy(function ($item) {
            return $item->hari_id . '-' . $item->jam_id;
        });

        foreach ($groupedJadwals as $key => $jadwalGroup) {
            for ($i = 0; $i < count($jadwalGroup); $i++) {
                for ($j = $i + 1; $j < count($jadwalGroup); $j++) {
                    $jadwal1 = $jadwalGroup[$i];
                    $jadwal2 = $jadwalGroup[$j];

                    if ($jadwal1->ruangan_id === $jadwal2->ruangan_id) {
                        $conflicts[] = [
                            'type' => 'Ruangan',
                            'id1' => $jadwal1->id,
                            'id2' => $jadwal2->id,
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
                            'jam2' => $jadwal2->jam->waktu
                        ];
                    }

                    if ($jadwal1->pengampu->dosen_id === $jadwal2->pengampu->dosen_id) {
                        $conflicts[] = [
                            'type' => 'Dosen',
                            'id1' => $jadwal1->id,
                            'id2' => $jadwal2->id,
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
                            'jam2' => $jadwal2->jam->waktu
                        ];
                    }
                }
            }
        }

        return $conflicts;
    }


    public function index(Request $request)
    {
        $kelasId = $request->input('kelas_id');
        $conflictFilter = $request->input('conflict_filter');
        $jadwalsQuery = Jadwal::with(['pengampu.dosen', 'pengampu.matkul', 'ruangan', 'jam', 'hari', 'kelas']);

        if (!empty($kelasId)) {
            $jadwalsQuery->where('kelas_id', $kelasId);
        }

        $jadwals = $jadwalsQuery->get();
        $kelas = Kelas::all(); // Get all classes for the filter dropdown

        $conflicts = $this->getConflicts();
        $conflictedJadwalIds = collect($conflicts)->pluck('id1')->merge(collect($conflicts)->pluck('id2'))->unique();

        if ($conflictFilter == 'conflict') {
            $jadwals = $jadwals->filter(function ($jadwal) use ($conflictedJadwalIds) {
                return $conflictedJadwalIds->contains($jadwal->id);
            });
        } elseif ($conflictFilter == 'no_conflict') {
            $jadwals = $jadwals->filter(function ($jadwal) use ($conflictedJadwalIds) {
                return !$conflictedJadwalIds->contains($jadwal->id);
            });
        }

        return view('admin.jadwal.index', [
            'jadwals' => $jadwals,
            'kelas' => $kelas,
            'selectedKelas' => $kelasId,
            'selectedConflictFilter' => $conflictFilter,
            'conflicts' => $conflicts
        ]);
    }

    public function checkConflicts()
    {
        $conflicts = $this->getConflicts();
        return response()->json(['conflicts' => $conflicts]);
    }

    public function generateSchedule($returnOnly = false)
    {
        try {
            $jumlahGenerasi = 1000;
            $jumlahIndividu = 30;
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

            if ($returnOnly) {
                return $jadwalTerbaik;
            }

            if (!empty($jadwalTerbaik)) {
                $geneticAlgorithm->simpanJadwal($jadwalTerbaik);
            }

            return response()->json($jadwalTerbaik);

        } catch (\Exception $e) {
            Log::error('Error generating schedule: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function delete()
    {
        try {
            Jadwal::truncate(); // Delete all records
            return redirect()->route('jadwal')->with('success', 'All schedules deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('jadwal')->with('error', 'Failed to delete schedules: ' . $e->getMessage());
        }
    }
    private function convertTimeRange($timeRange)
    {
        list($start_time_str, $end_time_str) = explode(" - ", $timeRange);

        // Mengonversi waktu mulai dan waktu selesai
        $start_time = \DateTime::createFromFormat('H:i', $start_time_str);
        $end_time = \DateTime::createFromFormat('H:i', $end_time_str);

        if (!$start_time || !$end_time) {
            throw new \Exception("Invalid time format: $timeRange");
        }

        return array('start' => $start_time->format('H:i'), 'end' => $end_time->format('H:i'));
    }
    public function edit(Request $request)
    {
        $kelasId = $request->input('kelas_id');
        $dosenId = $request->input('dosen_id');
        $jadwals = Jadwal::with(['pengampu.dosen', 'pengampu.matkul', 'ruangan', 'jam', 'hari', 'kelas']);

        if (!empty($kelasId)) {
            $jadwals = $jadwals->where('kelas_id', $kelasId);
        }

        if (!empty($dosenId)) {
            $jadwals = $jadwals->whereHas('pengampu.dosen', function ($query) use ($dosenId) {
                $query->where('id', $dosenId);
            });
        }

        $haris = Hari::all();
        $jams = Jam::all();
        $jadwals = $jadwals->get();
        $kelas = Kelas::all();
        $dosens = Dosen::all();

        return view('admin.jadwal.edit', [
            'jadwals' => $jadwals,
            'kelas' => $kelas,
            'dosens' => $dosens,
            'selectedKelas' => $kelasId,
            'selectedDosen' => $dosenId,
            'jams' => $jams,
            'haris' => $haris
        ]);
    }

    // public function update(Request $request)
    // {
    //     $data = $request->json()->all();
    //     $errors = [];

    //     foreach ($data as $item) {
    //         $jadwal = Jadwal::find($item['id']);
    //         if ($jadwal) {
    //             $hari = Hari::where('hari', $item['day'])->first();
    //             $jadwal->hari_id = $hari ? $hari->id : null;
    //             $jadwal->jam_id = $item['jam_id'];
    //             $jadwal->save();
    //                     // // Check for schedule conflicts
    //                     // $conflict = Jadwal::where('hari_id', $jadwal->hari_id)
    //                     //                 ->where('jam_id', $jadwal->jam_id)
    //                     //                 ->where(function ($query) use ($jadwal) {
    //                     //                     $query->where('ruangan_id', $jadwal->ruangan_id)
    //                     //                           ->orWhere('pengampu_id', $jadwal->pengampu_id);
    //                     //                 })
    //                     //                 ->where('id', '!=', $jadwal->id)
    //                     //                 ->first();

    //                     // if ($conflict) {
    //                     //     $errors[] = [
    //                     //         'id' => $jadwal->id,
    //                     //         'message' => "Conflict detected for schedule ID {$jadwal->id} with schedule ID {$conflict->id}.",
    //                     //         'details' => "Conflict in room or with the same lecturer."
    //                     //     ];
    //                     // } else {


    //         }
    //     }

    //     if (!empty($errors)) {
    //         return response()->json(['success' => false, 'errors' => $errors]);
    //     }

    //     return response()->json(['success' => true]);
    // }

    public function update(Request $request)
    {
        $data = $request->json()->all();
        $errors = [];

        foreach ($data as $item) {
            $jadwal = Jadwal::find($item['id']);
            if ($jadwal) {
                $hari = Hari::where('hari', $item['day'])->first();
                $newHariId = $hari ? $hari->id : null;
                $newJamId = $item['jam_id'];

                // Check if there is any change
                if ($jadwal->hari_id != $newHariId || $jadwal->jam_id != $newJamId) {
                    $jadwal->hari_id = $newHariId;
                    $jadwal->jam_id = $newJamId;

                    // Check for schedule conflicts before saving
                    $conflictRuangan = Jadwal::where('hari_id', $jadwal->hari_id)
                        ->where('jam_id', $jadwal->jam_id)
                        ->where('ruangan_id', $jadwal->ruangan_id)
                        ->where('id', '!=', $jadwal->id)
                        ->first();

                    $conflictDosen = Jadwal::where('hari_id', $jadwal->hari_id)
                        ->where('jam_id', $jadwal->jam_id)
                        ->whereHas('pengampu', function($query) use ($jadwal) {
                            $query->where('dosen_id', $jadwal->pengampu->dosen_id);
                        })
                        ->where('id', '!=', $jadwal->id)
                        ->first();

                    if ($conflictRuangan) {
                        $errors[] = [
                            'id' => $jadwal->id,
                            'dosen' => $jadwal->pengampu->dosen->nama_dosen,
                            'matkul' => $jadwal->pengampu->matkul->nama_matkul,
                            'message' => "Conflict detected for schedule ID {$jadwal->id} with schedule ID {$conflictRuangan->id}.",
                            'details' => "Conflict in room {$jadwal->ruangan->nama_ruangan}.",
                        ];
                    }

                    if ($conflictDosen) {
                        $errors[] = [
                            'id' => $jadwal->id,
                            'dosen' => $jadwal->pengampu->dosen->nama_dosen,
                            'matkul' => $jadwal->pengampu->matkul->nama_matkul,
                            'message' => "Conflict detected for schedule ID {$jadwal->id} with schedule ID {$conflictDosen->id}.",
                            'details' => "Conflict with the same lecturer {$jadwal->pengampu->dosen->nama_dosen}.",
                        ];
                    }

                    if (!$conflictRuangan && !$conflictDosen) {
                        $jadwal->save();
                    }
                }
            }
        }

        if (!empty($errors)) {
            return response()->json(['success' => false, 'errors' => $errors]);
        }

        return response()->json(['success' => true]);
    }




    // public function checkConflict(Request $request)
// {
//     $data = $request->json()->all();
//     $conflicts = [];

    //     foreach ($data as $item) {
//         $jadwal = Jadwal::find($item['id']);
//         if ($jadwal) {
//             $hari = Hari::where('hari', $item['day'])->first();
//             $jadwal->hari_id = $hari ? $hari->id : null;
//             $jadwal->jam_id = $item['jam_id'];

    //             // Check for schedule conflicts
//             $conflict = Jadwal::where('hari_id', $jadwal->hari_id)
//                 ->where('jam_id', $jadwal->jam_id)
//                 ->where(function ($query) use ($jadwal) {
//                     $query->where('ruangan_id', $jadwal->ruangan_id)
//                           ->orWhere('pengampu_id', $jadwal->pengampu_id);
//                 })
//                 ->where('id', '!=', $jadwal->id)
//                 ->first();

    //             if ($conflict) {
//                 $conflicts[] = [
//                     'id' => $jadwal->id,
//                     'dosen' => $jadwal->pengampu->dosen->nama_dosen,
//                     'matkul' => $jadwal->pengampu->matkul->nama_matkul,
//                     'message' => "Conflict detected for schedule ID {$jadwal->id} with schedule ID {$conflict->id}.",
//                     'details' => "Conflict in room or with the same lecturer.",
//                     'hari_id' => $jadwal->hari_id,
//                     'jam_id' => $jadwal->jam_id,
//                 ];
//             }
//         }
//     }

    //     return response()->json(['success' => empty($conflicts), 'conflicts' => $conflicts]);
// }


    public function printPDF(Request $request)
    {
        // Ambil data kelas dan jadwal dari database
        $kelas = Kelas::all();
        $jadwals = Jadwal::with(['hari', 'jam', 'pengampu.matkul', 'pengampu.dosen', 'ruangan'])->get();

        // Membuat spreadsheet baru
        $spreadsheet = new Spreadsheet();

        foreach ($kelas as $index => $kls) {
            // Buat sheet baru atau gunakan sheet pertama
            if ($index == 0) {
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setTitle($kls->nama_kelas);
            } else {
                $sheet = $spreadsheet->createSheet();
                $sheet->setTitle($kls->nama_kelas);
            }



            // Header
            $sheet->mergeCells("A1:G2"); // Menggabungkan A1 hingga G2
            $sheet->setCellValue("A1", "JADWAL KULIAH");
            $sheet->getStyle("A1")->getFont()->setBold(true)->setSize(16); // Ukuran font lebih besar
            $sheet->getStyle("A1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER); // Vertikal center

            // Subheader
            $sheet->setCellValue("A3", "Jurusan");
            $sheet->mergeCells("A3:C3");
            $sheet->setCellValue("D3", ": Teknik Elektro");
            $sheet->mergeCells("D3:G3");

            $sheet->setCellValue("A4", "Program Studi");
            $sheet->mergeCells("A4:C4");
            $sheet->setCellValue("D4", ": D3 Teknik Informatika");
            $sheet->mergeCells("D4:G4");

            $sheet->setCellValue("A5", "Semester");
            $sheet->mergeCells("A5:C5");
            $sheet->setCellValue("D5", ": IV (Empat) / Genap");
            $sheet->mergeCells("D5:G5");

            $sheet->setCellValue("A6", "Tahun Akademik");
            $sheet->mergeCells("A6:C6");
            $sheet->setCellValue("D6", ": 2023 - 2024");
            $sheet->mergeCells("D6:G6");

            $sheet->setCellValue("A7", "Kelas");
            $sheet->mergeCells("A7:C7");
            $sheet->setCellValue("D7", ": " . $kls->nama_kelas);
            $sheet->mergeCells("D7:G7");

            $sheet->setCellValue("A8", "Dosen Wali");
            $sheet->mergeCells("A8:C8");
            $sheet->setCellValue("D8", ": Amran Yobiokatbera, S.Kom., M.Kom.");
            $sheet->mergeCells("D8:G8");

            // Aligning the text to center
            $sheet->getStyle("A3:G8")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A3:G8")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

            // Table header
            $sheet->setCellValue("A9", "Hari");
            $sheet->setCellValue("B9", "Jam ke");
            $sheet->setCellValue("C9", "Waktu");
            $sheet->setCellValue("D9", "Kode MK");
            $sheet->setCellValue("E9", "Mata Kuliah");
            $sheet->setCellValue("F9", "Dosen");
            $sheet->setCellValue("G9", "Ruang");

            $sheet->getStyle("A9:G9")->getFont()->setBold(true);
            $sheet->getStyle("A9:G9")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A9:G9")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFCCCCCC');

            // Table content
            $currentHari = null;
            $row = 10;
            foreach ($jadwals->where('kelas_id', $kls->id)->sortBy(['hari_id', 'jam_id']) as $jadwal) {
                if ($jadwal->hari->hari != $currentHari) {
                    if ($currentHari) {
                        $row++; // Add an empty row as a separator
                    }
                    $currentHari = $jadwal->hari->hari;
                    $sheet->setCellValue("A$row", $jadwal->hari->hari);
                    $sheet->getStyle("A$row")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                    $sheet->mergeCells("A$row:A" . ($row + $jadwals->where('kelas_id', $kls->id)->where('hari_id', $jadwal->hari_id)->count() - 1));
                }
                $sheet->setCellValue("B$row", $jadwal->jam->jam);
                $sheet->setCellValue("C$row", $jadwal->jam->waktu);
                $sheet->setCellValue("D$row", $jadwal->pengampu->matkul->kode_matkul);
                $sheet->setCellValue("E$row", $jadwal->pengampu->matkul->nama_matkul);
                $sheet->setCellValue("F$row", $jadwal->pengampu->dosen->nama_dosen);
                $sheet->setCellValue("G$row", $jadwal->ruangan->nama_ruangan);
                $row++;
            }

            // Mengatur border untuk semua sel
            $styleArray = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'],
                    ],
                ],
            ];
            $sheet->getStyle("A9:G$row")->applyFromArray($styleArray);

            // Menyesuaikan lebar kolom
            $sheet->getColumnDimension('A')->setWidth(10);
            $sheet->getColumnDimension('B')->setWidth(8);
            $sheet->getColumnDimension('C')->setWidth(15);
            $sheet->getColumnDimension('D')->setWidth(15);
            $sheet->getColumnDimension('E')->setWidth(30);
            $sheet->getColumnDimension('F')->setWidth(35);
            $sheet->getColumnDimension('G')->setWidth(30);

            // Mengatur tinggi baris
            for ($i = 1; $i <= $row; $i++) {
                $sheet->getRowDimension($i)->setRowHeight(20);
            }

            // Mengatur alignment dan font pada seluruh sheet
            $sheet->getStyle("A1:G$row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A1:G$row")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A1:G$row")->getFont()->setName('Arial')->setSize(10);
        }

        // Set the first sheet as active
        $spreadsheet->setActiveSheetIndex(0);

        // Save to Excel file
        $writer = new Xlsx($spreadsheet);
        $filename = 'JadwalKuliah.xlsx';

        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }

}


