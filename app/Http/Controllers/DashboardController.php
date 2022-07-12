<?php

namespace App\Http\Controllers;

use App\Models\Keuangan\PemasukanEksternal;
use App\Models\Keuangan\PembayaranGaji;
use App\Models\Keuangan\PembayaranSpp;
use App\Models\Keuangan\PengeluaranLainnya;
use App\Models\Master\Asatidz;
use App\Models\Master\Santri;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = $this->data();
        return view('dashboard', compact('data'));
    }

    private function data()
    {
        $santri_aktif = Santri::active()->count();
        $santri_lulus = Santri::lulus()->count();
        $pendaftar = Santri::whereNull('status')->count();
        $asatidz = Asatidz::active()->count();

        $data = [
            'civitas' => [
                'santri' => $santri_aktif,
                'alumni' => $santri_lulus,
                'pendaftar' => $pendaftar,
                'asatidz' => $asatidz
            ]
        ];

        if (request()->user()->hasRole(['bendahara', 'pimpinan_pesantren'])) {
            $spp = PembayaranSpp::active()->sum('jumlah');
            $eksternal = PemasukanEksternal::batal(0)->sum('jumlah');

            $data['keuangan']['pemasukan'] = $spp + $eksternal;

            $gaji = PembayaranGaji::sum('jumlah_honor');
            $lainnya = PengeluaranLainnya::batal(0)->sum('jumlah');

            $data['keuangan']['pengeluaran'] = $gaji + $lainnya;

            $data['keuangan']['saldo'] = ($spp + $eksternal) - ($gaji + $lainnya);
        }
        // dd($data);
        return $data;
    }
}
