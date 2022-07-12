<?php

namespace App\Http\Controllers\Keuangan;

use App\DataTables\PengeluaranLainnyaDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\PengeluaranLainnyaRequest;
use App\Models\Keuangan\PengeluaranLainnya;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengeluaranLainnyaController extends Controller
{
    public function index(PengeluaranLainnyaDataTable $datatable)
    {
        return $datatable->render('keuangan.pengeluaran');
    }

    public function create()
    {
        return view('keuangan.pengeluaran-form');
    }

    public function store(PengeluaranLainnyaRequest $request)
    {
        DB::beginTransaction();
        try {
            PengeluaranLainnya::create([
                'tanggal' => reverseDate($request->tanggal),
                'nama_pengeluaran' => $request->nama_pengeluaran,
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
            $data = PengeluaranLainnya::where('id', decrypt($id))->first();
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
