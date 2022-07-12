<?php

namespace App\Http\Controllers\Keuangan;

use App\DataTables\PembayaranGajiDataTable;
use App\Http\Controllers\Controller;
use App\Models\Keuangan\PembayaranGaji;
use App\Models\Master\Asatidz;
use App\Services\FpdfHtmlService;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PembayaranGajiController extends Controller
{
    public function index(PembayaranGajiDataTable $datatable)
    {
        return $datatable->render('keuangan.pembayarangaji');
    }

    public function create()
    {
        return view('keuangan.pembayarangaji-form');
    }

    public function show($periode)
    {
        $data = Asatidz::withCount(['absensi' => function (Builder $query) use ($periode) {
            $month = explode('-', $periode);
            $query->whereMonth('tanggal', $month[0]);
        }])->get();

        return view('keuangan.pembayarangaji-show', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'periode' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $month = explode('-', $request->periode);
            $data = Asatidz::withCount(['absensi' => function (Builder $query) use ($month) {
                $query->whereMonth('tanggal', $month[0]);
            }])->get();

            $cek = PembayaranGaji::whereMonth('tanggal', $month[0])->first();
            if ($cek) {
                throw new Exception('Gaji sudah di distribusikan');
            }

            $insert = [];
            foreach ($data as $item) {
                $insert[] = [
                    'asatidz_id' => $item->id,
                    'tanggal' => now(),
                    'jumlah_kehadiran' => $item->absensi_count,
                    'upah_pertemuan' => $item->upah_pertemuan,
                    'jumlah_honor' => $item->absensi_count * $item->upah_pertemuan
                ];
            }

            PembayaranGaji::insert($insert);

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil disimpan',
                'reloadURL' => route('pembayaran-gaji.download', $request->periode)
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return responseMessage('error', $th->getMessage());
        }
    }

    public function download($periode, FpdfHtmlService $pdf)
    {
        $pdf->AddPage('', 'legal');
        $pdf->SetFont('Arial', 'B', '14');
        $pdf->SetTopMargin(30);
        $pdf->Cell($pdf->GetPageWidth() - 10, 0, 'DISTRIBUSI GAJI', 0, 0, 'C');

        $pdf->SetFont('Arial', '', 10);
        $pdf->SetXY(10, $pdf->GetY() + 20);
        $pdf->cell(40, 0, 'Periode', 0, 0, 'L');
        $pdf->cell(5, 0, ':', 0, 0, 'C');
        $pdf->cell(110, 0, $periode, 0, 0, 'L');

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetXY(10, $pdf->GetY() + 5);
        $pdf->SetFillColor(179, 177, 177);
        $pdf->Cell(10, 7, 'No', 1, 0, 'C', true);
        $pdf->Cell(65, 7, 'Nama Asatidz', 1, 0, 'C', true);
        $pdf->Cell(50, 7, 'Honor', 1, 0, 'C', true);
        $pdf->Cell(70, 7, 'TTD', 1, 0, 'C', true);
        $pdf->Ln();

        $data = Asatidz::withCount(['absensi' => function (Builder $query) use ($periode) {
            $month = explode('-', $periode);
            $query->whereMonth('tanggal', $month[0]);
        }])->get();

        $pdf->SetFont('Arial', '', 10);
        $no = 0;

        $pdf->SetFillColor(230, 230, 230);
        $fill = false;
        foreach ($data as $item) {
            $pdf->Cell(10, 7, ++$no, 1, 0, 'C', $fill);
            $pdf->Cell(65, 7, $item->nama_lengkap, 1, 0, 'L', $fill);

            $honor = numberFormat($item->absensi_count * $item->upah_pertemuan, 0, 'Rp ');
            $pdf->Cell(50, 7, $honor, 1, 0, 'L', $fill);
            $pdf->Cell(70, 7, $no . ".", 1, 0, $fill ? 'C' : 'L', $fill);
            $pdf->Ln();

            $fill = !$fill;
        }

        $pdf->Output('D', 'Distribusi Gaji Asatidz Periode ' . $periode . '.pdf');
        exit;
    }
}
