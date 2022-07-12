<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Absensi\AbsensiAsatidz;
use App\Services\FpdfHtmlService;
use Illuminate\Http\Request;

class LaporanAbsensiAsatidzController extends Controller
{
    public function index(Request $request)
    {
        $data = null;
        if ($request->tanggal) {
            $data = AbsensiAsatidz::with('asatidz:id,nama_lengkap')
                ->whereDate('tanggal', reverseDate($request->tanggal))
                ->get();
        }

        return view('laporan.absensiasatidz', compact('data'));
    }

    public function cetak(Request $request, FpdfHtmlService $pdf)
    {
        $pdf->AddPage('', 'legal');
        $pdf->SetFont('Arial', 'B', '14');
        $pdf->SetTopMargin(30);
        $pdf->Cell($pdf->GetPageWidth() - 10, 0, 'ABSENSI ASATIDZ', 0, 0, 'C');

        $data = AbsensiAsatidz::with('asatidz:id,nama_lengkap')
            ->whereDate('tanggal', reverseDate($request->tanggal))
            ->get();

        $pdf->SetFont('Arial', '', 10);
        $pdf->SetXY(10, $pdf->GetY() + 20);
        $pdf->cell(40, 0, 'Tanggal', 0, 0, 'L');
        $pdf->cell(5, 0, ':', 0, 0, 'C');
        $pdf->cell(110, 0, $request->tanggal, 0, 0, 'L');

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetXY(10, $pdf->GetY() + 5);
        $pdf->SetFillColor(179, 177, 177);
        $pdf->Cell(10, 7, 'No', 1, 0, 'C', true);
        $pdf->Cell(80, 7, 'Nama Asatidz', 1, 0, 'C', true);
        $pdf->Cell(25, 7, 'Kehadiran', 1, 0, 'C', true);
        $pdf->Cell(77, 7, 'Keterangan', 1, 0, 'C', true);
        $pdf->Ln();

        $pdf->SetFont('Arial', '', 10);
        $no = 0;

        $pdf->SetFillColor(230, 230, 230);
        $fill = false;
        foreach ($data as $item) {
            $kehadiran = $item->kehadiran == 'H' ? 'Hadir' : ($item->kehadiran == 'S' ? 'Sakit' : ($item->kehadiran == 'I' ? 'Izin' : 'Alpa'));
            $pdf->Cell(10, 7, ++$no, 1, 0, 'C', $fill);
            $pdf->Cell(80, 7, $item->asatidz->nama_lengkap, 1, 0, 'L', $fill);
            $pdf->Cell(25, 7, $kehadiran, 1, 0, 'C', $fill);
            $pdf->Cell(77, 7, $item->keterangan ?? '-', 1, 0, 'L', $fill);
            $pdf->Ln();

            $fill = !$fill;
        }

        $pdf->Output('I', 'Laporan Absensi Tanggal ' . $request->tanggal . '.pdf');
        exit;
    }
}
