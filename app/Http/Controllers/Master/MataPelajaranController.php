<?php

namespace App\Http\Controllers\Master;

use App\DataTables\MataPelajaranDataTable;
use App\Http\Controllers\Controller;
use App\Models\Master\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MataPelajaranController extends Controller
{
    public function index(MataPelajaranDataTable $datatable)
    {
        return $datatable->render('master.matapelajaran');
    }

    public function create()
    {
        return view('master.matapelajaran-form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'mata_pelajaran' => 'required',
            'hari' => 'required'
        ]);

        DB::beginTransaction();
        try {
            MataPelajaran::create([
                'nama_mapel' => strtoupper($request->mata_pelajaran),
                'hari' => strtoupper($request->hari)
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
        $data = MataPelajaran::where('id', decrypt($id))->first();
        if ($data) {
            $url = route('mata-pelajaran.update', $id);
            return view('master.matapelajaran-form', compact('data', 'url'));
        }

        return responseMessage('error', 'Data tidak ditemukan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'mata_pelajaran' => 'required',
            'hari' => 'required'
        ]);

        DB::beginTransaction();
        try {
            MataPelajaran::where('id', decrypt($id))->update([
                'nama_mapel' => strtoupper($request->mata_pelajaran),
                'hari' => strtoupper($request->hari)
            ]);

            DB::commit();
            return responseMessage();
        } catch (\Throwable $th) {
            DB::rollBack();
            return responseMessage('error', $th->getMessage());
        }
    }
}
