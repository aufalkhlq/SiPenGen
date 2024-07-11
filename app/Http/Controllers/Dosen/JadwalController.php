<?php
namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Jam;
use App\Models\Pengampu;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

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
        $jams = Jam::all();
        $user = Auth::guard('dosen')->user();
        $dosenId = $user->id;
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $eventsByDay = [];

        foreach ($days as $day) {
            $eventsByDay[$day] = [];
            $pengampus = Pengampu::where('dosen_id', $dosenId)->get();

            foreach ($pengampus as $pengampu) {
                $jadwals = Jadwal::where('pengampu_id', $pengampu->id)
                            ->whereHas('hari', function($query) use ($day) {
                                $query->where('hari', $day);
                            })
                            ->orderBy('jam_id')
                            ->get();

                foreach ($jadwals as $jadwal) {
                    try {
                        // Mengonversi waktu mulai dan waktu selesai
                        $convertedTimes = $this->convertTimeRange($jadwal->jam->waktu);
                        $lastEvent = end($eventsByDay[$day]);

                        if ($lastEvent &&
                            $lastEvent['end'] == $convertedTimes['start'] &&
                            $lastEvent['title'] == $pengampu->matkul->nama_matkul &&
                            $lastEvent['ruangan'] == $jadwal->ruangan->nama_ruangan
                        ) {
                            // Update end time of the last event if they are consecutive
                            $eventsByDay[$day][key($eventsByDay[$day])]['end'] = $convertedTimes['end'];
                        } else {
                            $eventsByDay[$day][] = [
                                'title' => $pengampu->matkul->nama_matkul,
                                'start' => $convertedTimes['start'],
                                'end' => $convertedTimes['end'],
                                'ruangan' => $jadwal->ruangan->nama_ruangan
                            ];
                        }
                    } catch (\Exception $e) {
                        \Log::error("Error converting time range: " . $e->getMessage());
                    }
                }
            }
        }

        return view('dosen.jadwal.index', compact('eventsByDay', 'jams'));
    }

    public function printPDF(Request $request)
    {
        // Get the currently authenticated lecturer
        $user = Auth::guard('dosen')->user();
        $dosenId = $user->id;

        // Retrieve schedules with related course and lecturer data for the lecturer's class
        $pengampus = Pengampu::with(['matkul', 'dosen'])
                             ->where('dosen_id', $dosenId)
                             ->get();

        // Create a new spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle("Jadwal Dosen");

        // Header
        $sheet->mergeCells("A1:G2"); // Merge cells A1 to G2
        $sheet->setCellValue("A1", "JADWAL KULIAH DOSEN");
        $sheet->getStyle("A1")->getFont()->setBold(true)->setSize(16); // Larger font size
        $sheet->getStyle("A1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER); // Vertical center

        // Subheader
        $sheet->setCellValue("A3", "Dosen");
        $sheet->mergeCells("A3:C3");
        $sheet->setCellValue("D3", ": " . $user->nama_dosen);
        $sheet->mergeCells("D3:G3");

        // Table header
        $sheet->setCellValue("A5", "Hari");
        $sheet->setCellValue("B5", "Jam ke");
        $sheet->setCellValue("C5", "Waktu");
        $sheet->setCellValue("D5", "Kode MK");
        $sheet->setCellValue("E5", "Mata Kuliah");
        $sheet->setCellValue("F5", "Ruangan");

        $sheet->getStyle("A5:F5")->getFont()->setBold(true);
        $sheet->getStyle("A5:F5")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A5:F5")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFCCCCCC');

        // Table content
        $currentHari = null;
        $row = 6;

        // Days of the week in the desired order
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        foreach ($days as $day) {
            foreach ($pengampus as $pengampu) {
                $jadwals = Jadwal::with(['hari', 'jam', 'ruangan'])
                            ->where('pengampu_id', $pengampu->id)
                            ->whereHas('hari', function($query) use ($day) {
                                $query->where('hari', $day);
                            })
                            ->orderBy('jam_id')
                            ->get();

                foreach ($jadwals as $jadwal) {
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
                    $sheet->setCellValue("D$row", $pengampu->matkul->kode_matkul);
                    $sheet->setCellValue("E$row", $pengampu->matkul->nama_matkul);
                    $sheet->setCellValue("F$row", $jadwal->ruangan->nama_ruangan);
                    $row++;
                }
            }
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
        $sheet->getStyle("A5:F$row")->applyFromArray($styleArray);

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(8);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(20);

        // Set row heights
        for ($i = 1; $i <= $row; $i++) {
            $sheet->getRowDimension($i)->setRowHeight(20);
        }

        // Set alignment and font for the entire sheet
        $sheet->getStyle("A1:F$row")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:F$row")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle("A1:F$row")->getFont()->setName('Arial')->setSize(10);

        // Set the first sheet as active
        $spreadsheet->setActiveSheetIndex(0);

        // Save to Excel file
        $writer = new Xlsx($spreadsheet);
        $filename = 'JadwalDosen.xlsx';

        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }

}
