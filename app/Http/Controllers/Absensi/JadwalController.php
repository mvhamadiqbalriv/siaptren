<?php

namespace App\Http\Controllers\Absensi;

use App\DataTables\JadwalDataTable;
use App\Http\Controllers\Controller;
use App\Models\Absensi\Jadwal;
use App\Models\Master\Asatidz;
use App\Models\Master\MataPelajaran;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JadwalController extends Controller
{
    public function index(JadwalDataTable $datatable)
    {
        return $datatable->render('absensi.jadwal');
    }

    public function create()
    {
        $asatidz = Asatidz::whereAktif(1)->get();
        $mapel = MataPelajaran::all();

        return view('absensi.jadwal-form', compact('asatidz', 'mapel'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mata_pelajaran' => 'required',
            'pengajar' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $asatidz = Asatidz::where('kode_asatidz', $request->pengajar)->first();
            $kode_asatidz = substr($asatidz->kode_asatidz, 3);

            $cek = Jadwal::where([
                ['asatidz_id', $asatidz->id],
                ['mapel_id', $request->mata_pelajaran]
            ])->first();
            if ($cek) {
                throw new Exception('Jadwal sudah ada');
            }

            Jadwal::create([
                'asatidz_id' => $asatidz->id,
                'mapel_id' => $request->mata_pelajaran,
                'kode_jadwal' => generateKode('mapel_asatidz', 'kode_jadwal', 'MU' . $kode_asatidz, 1)
            ]);

            DB::commit();
            return responseMessage();
        } catch (\Throwable $th) {
            DB::rollBack();
            return responseMessage('error', $th->getMessage());
        }
    }

    public function edit($id)
    {
        $asatidz = Asatidz::whereAktif(1)->get();
        $mapel = MataPelajaran::all();
        $data = Jadwal::from('mapel_asatidz as ma')
            ->leftJoin('asatidz as a', 'ma.asatidz_id', '=', 'a.id')
            ->select('ma.mapel_id', 'ma.aktif', 'a.kode_asatidz', 'a.id as asatidz_id')
            ->where('kode_jadwal', decrypt($id))
            ->first();

        $url = route('jadwal.update', $id);

        return view('absensi.jadwal-form', compact('asatidz', 'mapel', 'data', 'url'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $aktif = $request->aktif ? 1 : 0;
            Jadwal::where('kode_jadwal', decrypt($id))->update(['aktif' => $aktif]);

            DB::commit();
            return responseMessage();
        } catch (\Throwable $th) {
            DB::rollBack();
            return responseMessage('error', $th->getMessage());
        }
    }
}
