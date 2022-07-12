<?php

namespace App\Http\Controllers\Absensi;

use App\DataTables\AbsensiSantriDataTable;
use App\Http\Controllers\Controller;
use App\Models\Absensi\AbsensiSantri;
use App\Models\Absensi\Jadwal;
use App\Models\Master\Santri;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AbsensiSantriController extends Controller
{
    public function index(AbsensiSantriDataTable $datatable)
    {
        return $datatable->render('absensi.santri');
    }

    public function create()
    {
        return view('absensi.santri-form');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $santri = Santri::where('kode_santri', $request->id)->first();
            if (!$santri) {
                throw new Exception('Data santri tidak ditemukan');
            }

            $cek = AbsensiSantri::where([
                'kode_jadwal' => $request->jadwal,
                'santri_id' => $santri->id,
                'tanggal' => reverseDate($request->tanggal)
            ])->first();
            if ($cek) {
                throw new Exception("Santri atas nama $santri->nama_lengkap sudah diabsen");
            }

            AbsensiSantri::create([
                'santri_id' => $santri->id,
                'kode_jadwal' => $request->jadwal,
                'tanggal' => reverseDate($request->tanggal),
                'kehadiran' => $request->kehadiran,
                'keterangan' => $request->keterangan,
                'user' => $request->user()->username,
            ]);

            $html = [
                'H' => 'Hadir',
                'S' => 'Sakit',
                'I' => "<span>Izin<span><p>$request->keterangan<p>",
                'A' => 'Alpa'
            ];

            DB::commit();
            return response()->json([
                'status' => 'success',
                'html' => $html[$request->kehadiran]
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return responseMessage('error', $th->getMessage());
        }
    }

    public function jadwal($tanggal)
    {
        $hari = dateFormat($tanggal, 'l');

        $jadwal = Jadwal::from('mapel_asatidz as mp')
            ->leftJoin('asatidz as a', 'a.id', '=', 'mp.asatidz_id')
            ->leftJoin('mata_pelajaran as mpl', 'mpl.id', '=', 'mp.mapel_id')
            ->select('mp.kode_jadwal', 'mpl.nama_mapel', 'a.nama_lengkap')
            ->where([
                ['mpl.hari', $hari],
                ['mp.aktif', 1]
            ])
            ->get();

        return response()->json([
            'status' => 'success',
            'jadwal' => $jadwal,
            'total' => $jadwal->count()
        ]);
    }

    public function list($kode_jadwal, $tanggal)
    {
        $data = Santri::whereStatus('Aktif')
            ->whereNotIn('id', function ($query) use ($kode_jadwal, $tanggal) {
                $query->select('santri_id')->from('absensi_santri')->where([
                    ['kode_jadwal', $kode_jadwal],
                    ['tanggal', reverseDate($tanggal)]
                ]);
            })->get();

        return view('absensi.santri-list', compact('data'));
    }

    public function edit($id)
    {
        $url = route('absensi-santri.update', $id);
        $data = AbsensiSantri::from('absensi_santri as abs')
            ->leftJoin('santri', 'abs.santri_id', '=', 'santri.id')
            ->leftJoin('mapel_asatidz as ma', 'ma.kode_jadwal', '=', 'abs.kode_jadwal')
            ->leftJoin('mata_pelajaran as mp', 'mp.id', '=', 'ma.mapel_id')
            ->leftJoin('asatidz as ast', 'ast.id', '=', 'ma.asatidz_id')
            ->select('abs.*', 'santri.nama_lengkap as santri', 'mp.nama_mapel', 'ast.nama_lengkap as pengajar')
            ->where('abs.id', decrypt($id))
            ->first();

        return view('absensi.santri-form', compact('url', 'data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kehadiran' => 'required',
            'keterangan' => Rule::requiredIf(function () use ($request) {
                return $request->kehadiran == 'I';
            })
        ]);

        DB::beginTransaction();
        try {
            AbsensiSantri::where('id', decrypt($id))->update([
                'kehadiran' => $request->kehadiran,
                'keterangan' => $request->kehadiran == 'I' ? $request->keterangan : null
            ]);

            DB::commit();
            return responseMessage();
        } catch (\Throwable $th) {
            DB::rollBack();
            return responseMessage('error', $th->getMessage());
        }
    }
}
