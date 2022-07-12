<?php

namespace App\Http\Controllers\Keuangan;

use App\DataTables\PembayaranSppDataTable;
use App\Http\Controllers\Controller;
use App\Models\Keuangan\PembayaranSpp;
use App\Models\Master\Santri;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PembayaranSppController extends Controller
{
    public function index(PembayaranSppDataTable $datatable)
    {
        return $datatable->render('keuangan.pembayaranspp');
    }

    public function create()
    {
        return view('keuangan.pembayaranspp-form');
    }

    public function store(Request $request)
    {
        $data = PembayaranSpp::with('santri.tunggakan')->where([
            ['batal', 0],
            ['santri_id', $request->santri]
        ])->orderBy('tanggal')->get();

        $request->validate([
            'santri' => 'required',
            'periode_awal' => Rule::requiredIf(function () use ($data) {
                return $data->count() == 0;
            }),
            'jumlah_bayar' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $jumlah_bayar = preg_replace('/\D/', '', $request->jumlah_bayar);

            $tunggakan = 0;
            $sisa_bayar = 0;
            if ($request->periode_awal) {

                $jumlah_bulan_terbayar = ceil($jumlah_bayar / spp());
                $periode_awal = dateFormat('01-' . $request->periode_awal, 'Ym');
                $periode_akhir = (new DateTime('01-' . $request->periode_awal))->modify("+$jumlah_bulan_terbayar months");
                $periode_akhir = $periode_akhir->format('Ym') - 1;

                $bulan_ini = date('Ym');
                $selisih_bulan = $bulan_ini - $periode_akhir;

                if ($selisih_bulan > 0) {
                    $seharusnya_bayar = ($jumlah_bulan_terbayar + $selisih_bulan) * spp();
                    $tunggakan = $seharusnya_bayar - $jumlah_bayar;
                } elseif ($selisih_bulan < 0) {
                    $sisa_bayar = $jumlah_bayar - spp();
                }

                // dd($selisih_bulan, $sisa_bayar);
            } else {
                $data = $data->last();
                $tunggakan_sebelumnya = $data->santri->tunggakan->tunggakan;
                $selisih_bulan = date('Ym') - $data->santri->tunggakan->periode_tunggakan;

                if ($selisih_bulan > 0) {
                    $tunggakan_saat_ini = $tunggakan_sebelumnya + (spp() * $selisih_bulan);
                } else {
                    $tunggakan_saat_ini = $tunggakan_sebelumnya;
                }

                if ($tunggakan_saat_ini > 0) {
                    $tunggakan = $tunggakan_saat_ini - $jumlah_bayar;
                    if ($tunggakan < 0) {
                        $sisa_bayar = abs($tunggakan);
                        $penambahan_bulan = ceil($sisa_bayar / spp());
                        $periode_akhir = date('Ym') + $penambahan_bulan;
                        $tunggakan = 0;
                    } elseif ($tunggakan > 0) {
                        $pengurangan_bulan = ceil($tunggakan / spp());
                        $periode_akhir = date('Ym') - $pengurangan_bulan;
                    } else {
                        $periode_akhir = date('Ym');
                    }
                } else {
                    $penambahan_bulan = ceil(($jumlah_bayar - (spp() - $data->santri->tunggakan->sisa_bayar)) / spp());
                    $periode_akhir = $data->santri->tunggakan->periode_akhir_bayar + $penambahan_bulan;
                    $sisa_bayar = $data->santri->tunggakan->sisa_bayar + $jumlah_bayar;
                }
            }

            $santri = Santri::with('tunggakan')->where('id', $request->santri)->first();
            $santri->pembayaranSpp()->create([
                'kode_pembayaran' => generateKode('pembayaran_spp', 'kode_pembayaran', 'PB' . date('ym'), 4),
                'tanggal' => now(),
                'jumlah' => $jumlah_bayar,
                'periode_akhir_bayar' => $periode_akhir,
                'user' => $request->user()->username
            ]);

            if ($santri->tunggakan) {
                $data_tunggakan = $santri->tunggakan;
                $data_tunggakan->periode_akhir_bayar = $periode_akhir;
                $data_tunggakan->periode_tunggakan = date('Ym');
                $data_tunggakan->tunggakan = $tunggakan;
                $data_tunggakan->sisa_bayar = $sisa_bayar;
                $data_tunggakan->save();
            } else {
                $santri->tunggakan()->create([
                    'periode_awal_bayar' => $periode_awal,
                    'periode_akhir_bayar' => $periode_akhir,
                    'periode_tunggakan' => date('Ym'),
                    'tunggakan' => $tunggakan,
                    'sisa_bayar' => $sisa_bayar
                ]);
            }


            DB::commit();
            return responseMessage();
        } catch (\Throwable $th) {
            DB::rollBack();
            return responseMessage('error', $th->getMessage());
        }
    }

    public function santri(Request $request)
    {
        $data = Santri::whereStatus('Aktif')->where(function ($query) use ($request) {
            if ($request->search) {
                $query->where('nama_lengkap', 'like', "%$request->search%")
                    ->orWhere('kode_santri', 'like', "%$request->search%");
            }
        })->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'text' => $item->kode_santri . ' - ' . $item->nama_lengkap
            ];
        });

        return response()->json([
            'results' => $data
        ]);
    }

    public function tunggakan($santri)
    {
        $pembayaran = PembayaranSpp::with('santri.tunggakan')->where([
            ['batal', 0],
            ['santri_id', $santri]
        ])->orderBy('tanggal')->get();

        $data = $pembayaran->last();
        if ($data) {
            $selisih_bulan = date('Ym') - $data->santri->tunggakan->periode_tunggakan;
            $data->tunggakan = $data->santri->tunggakan->tunggakan;
            if ($selisih_bulan > 0) {
                $data->tunggakan += spp() * $selisih_bulan;
            }
        }

        return view('keuangan.pembayaranspp-tunggakan', compact('data'));
    }

    public function show($id)
    {
        $data = PembayaranSpp::with('santri')->where('id', decrypt($id))->first();
        return view('keuangan.pembayaranspp-detail', compact('data'));
    }

    public function update(Request $request, $id)
    {
        try {
            $pembayaran = PembayaranSpp::find(decrypt($id));
            $pembayaran->batal = 1;
            $pembayaran->user_batal = $request->user()->username;
            $pembayaran->keterangan_batal = $request->keterangan;
            $pembayaran->save();

            return responseMessage();
        } catch (\Throwable $th) {
            return responseMessage('error', 'Pembatalan gagal');
        }
    }
}
