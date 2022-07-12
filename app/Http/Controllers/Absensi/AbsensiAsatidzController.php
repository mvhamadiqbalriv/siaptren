<?php

namespace App\Http\Controllers\Absensi;

use App\DataTables\AbsensiAsatidzDataTable;
use App\Http\Controllers\Controller;
use App\Models\Absensi\AbsensiAsatidz;
use App\Models\Absensi\Jadwal;
use App\Models\Master\Asatidz;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AbsensiAsatidzController extends Controller
{
    public function index(AbsensiAsatidzDataTable $datatable)
    {
        return $datatable->render('absensi.asatidz');
    }

    public function create()
    {
        $asatidz = Asatidz::doesntHave('absensiHariIni')->active()->get();
        $jadwal = Jadwal::with(['mapel', 'asatidz'])
            ->whereHas('mapel', function (Builder $query) {
                $query->where('hari', days(date('l')));
            })->active()->get();
        return view('absensi.asatidz-form', compact('asatidz', 'jadwal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jadwal' => 'required',
            'kehadiran' => 'required',
            'keterangan' => Rule::requiredIf(function () {
                return request('kehadiran') == 'I';
            })
        ]);
        DB::beginTransaction();
        try {
            $cek = AbsensiAsatidz::whereDate('tanggal', date('Y-m-d'))
                ->where('kode_jadwal', $request->jadwal)
                ->get();

            if ($cek->count()) {
                throw new Exception('Absensi sudah ada');
            }

            $jadwal = Jadwal::with(['asatidz', 'mapel'])
                ->where('kode_jadwal', $request->jadwal)
                ->active()
                ->first();
            if (!$jadwal) {
                throw new Exception('Jadwal tidak ada');
            }

            AbsensiAsatidz::create([
                'kode_jadwal' => $request->jadwal,
                'tanggal' => now(),
                'asatidz_id' => $jadwal->asatidz->id,
                'kehadiran' => $request->kehadiran,
                'keterangan' => $request->kehadiran == 'I' ? $request->keterangan : null,
                'user' => $request->user()->username,
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
        $data = AbsensiAsatidz::with(['asatidz', 'jadwal.mapel'])
            ->where('id', decrypt($id))->first();

        $url = route('absensi-asatidz.update', $id);

        return view('absensi.asatidz-form', compact('data', 'url'));
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
            AbsensiAsatidz::where('id', decrypt($id))->update([
                'kehadiran' => $request->kehadiran,
                'keterangan' => $request->kehadiran == 'I' ? $request->kehadiran : null,
                'user_update' => $request->user()->username,
                'waktu_update' => now()
            ]);

            DB::commit();
            return responseMessage();
        } catch (\Throwable $th) {
            DB::rollBack();
            return responseMessage('error', $th->getMessage());
        }
    }
}
