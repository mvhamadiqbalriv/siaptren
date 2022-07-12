<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Keuangan\PemasukanEksternal;
use App\Services\FpdfHtmlService;
use Illuminate\Http\Request;

class LaporanPemasukanEksternalController extends Controller
{
    public function index(Request $request)
    {
        $data = null;
        if ($request->tanggal_awal and $request->tanggal_akhir) {
            $data = PemasukanEksternal::batal(0)->where([
                ['tanggal', '>=', reverseDate($request->tanggal_awal)],
                ['tanggal', '<=', reverseDate($request->tanggal_akhir)]
            ])->get();

            if ($data->count() == 0) $data = null;
        }

        return view('laporan.pemasukaneksternal', compact('data'));
    }

    public function cetak(Request $request, FpdfHtmlService $pdf)
    {
        $pdf->AddPage('', 'legal');
        $pdf->SetFont('Arial', 'B', '14');
        $pdf->SetTopMargin(30);
        $pdf->Cell($pdf->GetPageWidth() - 10, 0, 'PEMASUKAN EKSTERNAL', 0, 0, 'C');

        $pdf->SetFont('Arial', '', 10);
        $pdf->SetXY(10, $pdf->GetY() + 20);
        $pdf->cell(40, 0, 'Periode', 0, 0, 'L');
        $pdf->cell(5, 0, ':', 0, 0, 'C');
        $pdf->cell(110, 0, $request->tanggal_awal . " s/d $request->tanggal_akhir", 0, 0, 'L');

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetXY(10, $pdf->GetY() + 5);
        $pdf->SetFillColor(179, 177, 177);
        $pdf->Cell(10, 7, 'No', 1, 0, 'C', true);
        $pdf->Cell(65, 7, 'Nama Pemasukan', 1, 0, 'C', true);
        $pdf->Cell(90, 7, 'Keterangan', 1, 0, 'C', true);
        $pdf->Cell(30, 7, 'Jumlah', 1, 0, 'C', true);
        $pdf->Ln();

        $data = PemasukanEksternal::batal(0)->where([
            ['tanggal', '>=', reverseDate($request->tanggal_awal)],
            ['tanggal', '<=', reverseDate($request->tanggal_akhir)]
        ])->get();

        $pdf->SetFont('Arial', '', 10);
        $no = 0;

        $pdf->SetFillColor(230, 230, 230);
        $fill = false;
        foreach ($data as $item) {
            $pdf->Cell(10, 7, ++$no, 1, 0, 'C', $fill);
            $pdf->Cell(65, 7, $item->nama_pemasukan, 1, 0, 'L', $fill);
            $pdf->Cell(90, 7, $item->keterangan, 1, 0, 'L', $fill);
            $pdf->Cell(30, 7, numberFormat($item->jumlah, 0, 'Rp '), 1, 0, 'R', $fill);
            $pdf->Ln();

            $fill = !$fill;
        }
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFillColor(179, 177, 177);
        $pdf->Cell(165, 7, 'GRAND TOTAL', 1, 0, 'L', true);
        $pdf->Cell(30, 7, numberFormat($data->sum('jumlah'), 0, 'Rp '), 1, 0, 'R', true);

        $pdf->Output('I', 'Laporan Pemasukan Eksternal Tanggal ' . $request->tanggal_awal . " sd $request->tanggal_akhir" . '.pdf');
        exit;
    }
}
