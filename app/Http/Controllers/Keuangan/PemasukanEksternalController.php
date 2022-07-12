<?php

namespace App\Http\Controllers\Keuangan;

use App\DataTables\PemasukanEksternalDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\PemasukanEksternalRequest;
use App\Models\Keuangan\PemasukanEksternal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PemasukanEksternalController extends Controller
{
    public function index(PemasukanEksternalDataTable $datatable)
    {
        return $datatable->render('keuangan.pemasukan');
    }

    public function create()
    {
        return view('keuangan.pemasukan-form');
    }

    public function store(PemasukanEksternalRequest $request)
    {
        DB::beginTransaction();
        try {
            PemasukanEksternal::create([
                'tanggal' => reverseDate($request->tanggal),
                'nama_pemasukan' => $request->nama_pemasukan,
                'jumlah' => preg_replace('/\D/', '', $request->jumlah),
                'keterangan' => $request->keterangan,
                'user' => $request->user()->username
            ]);

            DB::commit();
            return responseMessage();
        } catch (\Throwable $th) {
            DB::rollBack();
            return responseMessage('error', $th->getMessage());
        }
    }

    public function batal(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $data = PemasukanEksternal::where('id', decrypt($id))->first();
            $data->batal = 1;
            $data->user_batal = $request->user()->username;
            $data->keterangan_batal = $request->keterangan;
            $data->save();

            DB::commit();
            return responseMessage();
        } catch (\Throwable $th) {
            DB::rollBack();
            return responseMessage('error', $th->getMessage());
        }
    }
}
