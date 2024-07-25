<?php
namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Jam;
use App\Models\Kelas;
use App\Models\Hari;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
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

        return array('start' => $start_time->format('H:i'), 'end' => $end_time->format('H:i'));
    }



    public function index(Request $request)
    {
        // Memastikan bahwa user telah login
        if (Auth::guard('mahasiswa')->check()) {
            $userKelasId = Auth::guard('mahasiswa')->user()->kelas_id;
        } else {
            // Handle the case where the user is not logged in
            return redirect()->route('login');
        }

        $kelasId = $request->input('kelas_id');
        $jadwals = Jadwal::with(['pengampu.dosen', 'pengampu.matkul', 'ruangan', 'jam', 'hari', 'kelas']);

        // Filter jadwals by user's class if no specific class is requested
        if (!empty($kelasId)) {
            $jadwals = $jadwals->where('kelas_id', $kelasId);
        } else {
            $jadwals = $jadwals->where('kelas_id', $userKelasId);
        }

        $haris = Hari::all();
        $jams = Jam::all();
        $jadwals = $jadwals->get();
        $kelas = Kelas::all(); // Get all classes for the filter dropdown

        return view('mahasiswa.jadwal.index', [
            'jadwals' => $jadwals,
            'kelas' => $kelas,
            'selectedKelas' => $kelasId ?: $userKelasId,
            'jams' => $jams,
            'haris' => $haris
        ]);
    }


    public function printPDF(Request $request)
    {
        // Get the currently authenticated student
        $user = Auth::guard('mahasiswa')->user();
        $kelasId = $user->kelas_id;

        // Get the class and schedule data from the database
        $kelas = Kelas::find($kelasId);
        if (!$kelas) {
            abort(404, 'Kelas not found');
        }

        $jadwals = Jadwal::with(['hari', 'jam', 'pengampu.matkul', 'pengampu.dosen', 'ruangan'])
            ->where('kelas_id', $kelasId)
            ->get();

        // Create a new spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle($kelas->nama_kelas);


        // Header
        $sheet->mergeCells("A1:G2"); // Merge cells A1 to G2
        $sheet->setCellValue("A1", "JADWAL KULIAH");
        $sheet->getStyle("A1")->getFont()->setBold(true)->setSize(16); // Larger font size
        $sheet->getStyle("A1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER); // Vertical center

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
        $sheet->setCellValue("D7", ": " . $kelas->nama_kelas);
        $sheet->mergeCells("D7:G7");

        $sheet->setCellValue("A8", "Dosen Wali");
        $sheet->mergeCells("A8:C8");
        $sheet->setCellValue("D8", ": Amran Yobiokatbera, S.Kom., M.Kom.");
        $sheet->mergeCells("D8:G8");

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
        foreach ($jadwals->sortBy(['hari_id', 'jam_id']) as $jadwal) {
            if ($jadwal->hari->hari != $currentHari) {
                if ($currentHari) {
                    $row++; // Add an empty row as a separator
                }
                $currentHari = $jadwal->hari->hari;
                $sheet->setCellValue("A$row", $jadwal->hari->hari);
                $sheet->getStyle("A$row")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->mergeCells("A$row:A" . ($row + $jadwals->where('hari_id', $jadwal->hari_id)->count() - 1));
            }
            $sheet->setCellValue("B$row", $jadwal->jam->jam);
            $sheet->setCellValue("C$row", $jadwal->jam->waktu);
            $sheet->setCellValue("D$row", $jadwal->pengampu->matkul->kode_matkul);
            $sheet->setCellValue("E$row", $jadwal->pengampu->matkul->nama_matkul);
            $sheet->setCellValue("F$row", $jadwal->pengampu->dosen->nama_dosen);
            $sheet->setCellValue("G$row", $jadwal->ruangan->nama_ruangan);
            $row++;
        }

        // Apply borders to all cells
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];
        $sheet->getStyle("A9:G$row")->applyFromArray($styleArray);

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(8);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(35);
        $sheet->getColumnDimension('G')->setWidth(30);

        // Set row heights
        for ($i = 1; $i <= $row; $i++) {
            $sheet->getRowDimension($i)->setRowHeight(20);
        }

        // Set alignment and font for the entire sheet
        $sheet->getStyle("A1:G$row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:G$row")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle("A1:G$row")->getFont()->setName('Arial')->setSize(10);

        // Set the first sheet as active
        $spreadsheet->setActiveSheetIndex(0);

        // Save to Excel file
        $writer = new Xlsx($spreadsheet);
        $filename = 'JadwalKelas' . $kelas->nama_kelas . '.xlsx';

        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }
}
