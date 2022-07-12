<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Absensi\AbsensiSantri;
use App\Models\Absensi\Jadwal;
use App\Models\Master\MataPelajaran;
use App\Services\FpdfHtmlService;
use DateTime;
use Illuminate\Http\Request;

class LaporanAbsensiSantriController extends Controller
{
    public function index(Request $request)
    {
        $mapel = null;
        $jadwal = null;
        $data = null;
        if ($request->tanggal) {
            $day = (new DateTime($request->tanggal))->format('l');
            $hari = days($day);

            $mapel = MataPelajaran::where('hari', $hari)->get();
        }

        if ($request->mata_pelajaran) {
            $jadwal = Jadwal::with('asatidz')->where('mapel_id', $request->mata_pelajaran)->get();
        }

        if ($request->tanggal and $request->mata_pelajaran and $request->guru_pengajar) {
            $mapel_asatidz = Jadwal::where([
                ['asatidz_id', $request->guru_pengajar],
                ['mapel_id', $request->mata_pelajaran],
            ])->active()
                ->first();
            $data = AbsensiSantri::with('santri:id,nama_lengkap')
                ->where([
                    ['kode_jadwal', $mapel_asatidz->kode_jadwal],
                    ['tanggal', '=', reverseDate($request->tanggal)]
                ])->get();

            if ($data->count() == 0) {
                $data = null;
            }
        }

        return view('laporan.absensisantri', compact('mapel', 'jadwal', 'data'));
    }

    public function getMapel($tanggal)
    {
        $day = (new DateTime($tanggal))->format('l');
        $hari = days($day);

        $mapel = MataPelajaran::where('hari', $hari)->get();
        $option = '<option selected disabled>Pilih Mata Pelajaran</option>';
        foreach ($mapel as $m) {
            $option .= "<option value='$m->id'>$m->nama_mapel</option>";
        }

        return $option;
    }

    public function getGuru($mapel)
    {
        $jadwal = Jadwal::with('asatidz')->where('mapel_id', $mapel)->get();
        $option = '<option selected disabled>Pilih Guru Pengajar</option>';
        foreach ($jadwal as $j) {
            $kode = $j->asatidz->id;
            $nama = $j->asatidz->nama_lengkap;
            $option .= "<option value='$kode'>$nama</option>";
        }

        return $option;
    }

    public function cetak(Request $request, FpdfHtmlService $pdf)
    {
        $pdf->AddPage('', 'legal');
        $pdf->SetFont('Arial', 'B', '14');
        $pdf->SetTopMargin(30);
        $pdf->Cell($pdf->GetPageWidth() - 10, 0, 'ABSENSI SANTRI', 0, 0, 'C');

        $mapel_asatidz = Jadwal::with(['asatidz:id,nama_lengkap', 'mapel:id,nama_mapel'])->where([
            ['asatidz_id', $request->guru_pengajar],
            ['mapel_id', $request->mata_pelajaran],
        ])->active()
            ->first();
        $data = AbsensiSantri::with('santri:id,nama_lengkap')
            ->where([
                ['kode_jadwal', $mapel_asatidz->kode_jadwal],
                ['tanggal', '=', reverseDate($request->tanggal)]
            ])->get();

        $pdf->SetFont('Arial', '', 10);
        $pdf->SetXY(10, $pdf->GetY() + 20);
        $pdf->cell(40, 0, 'Mata Pelajaran', 0, 0, 'L');
        $pdf->cell(5, 0, ':', 0, 0, 'C');
        $pdf->cell(110, 0, $mapel_asatidz->kode_jadwal . " - " . $mapel_asatidz->mapel->nama_mapel, 0, 0, 'L');

        $pdf->SetXY(10, $pdf->GetY() + 7);
        $pdf->cell(40, 0, 'Pengajar', 0, 0, 'L');
        $pdf->cell(5, 0, ':', 0, 0, 'C');
        $pdf->cell(110, 0, $mapel_asatidz->asatidz->nama_lengkap, 0, 0, 'L');

        $pdf->SetXY(10, $pdf->GetY() + 7);
        $pdf->cell(40, 0, 'Tanggal', 0, 0, 'L');
        $pdf->cell(5, 0, ':', 0, 0, 'C');
        $pdf->cell(110, 0, $request->tanggal, 0, 0, 'L');

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetXY(10, $pdf->GetY() + 10);
        $pdf->SetFillColor(179, 177, 177);
        $pdf->Cell(10, 7, 'No', 1, 0, 'C', true);
        $pdf->Cell(80, 7, 'Nama Santri', 1, 0, 'C', true);
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
            $pdf->Cell(80, 7, $item->santri->nama_lengkap, 1, 0, 'L', $fill);
            $pdf->Cell(25, 7, $kehadiran, 1, 0, 'C', $fill);
            $pdf->Cell(77, 7, $item->keterangan ?? '-', 1, 0, 'L', $fill);
            $pdf->Ln();

            $fill = !$fill;
        }

        $pdf->Output('I', 'Laporan Absensi Tanggal ' . $request->tanggal . '.pdf');
        exit;
    }
}
