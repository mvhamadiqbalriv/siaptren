<?php

namespace App\Http\Controllers\Master;

use App\DataTables\AlumniDataTable;
use App\Exports\AlumniExport;
use App\Http\Controllers\Controller;
use App\Models\Master\Santri;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class AlumniController extends Controller
{
    public function index(AlumniDataTable $datatable)
    {
        return $datatable->render('master.alumni');
    }

    public function show($id)
    {
        $data = Santri::where('kode_santri', decrypt($id))->first();
        if ($data) {
            return view('master.alumni-detail', compact('data'));
        }
        return responseMessage('error', 'Data tidak ditemukan');
    }

    public function edit($id){
        $data = Santri::where('kode_santri', decrypt($id))->first();
        return view('master.alumni-form', compact('data'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'nomor_handphone' => 'required',
            'email' => [
                'required',
                Rule::unique('santri', 'email')->ignore(decrypt($id), 'kode_santri')
            ],
            'alamat' => 'required'
        ]);

        try {
            $santri = Santri::where('kode_santri', decrypt($id))->first();
            $santri->nomor_handphone = $request->nomor_handphone;
            $santri->email = $request->email;
            $santri->alamat = $request->alamat;
            $santri->pekerjaan = $request->pekerjaan;
            $santri->save();

            return responseMessage();
        } catch (\Throwable $th) {
            return responseMessage('error', 'Data gagal disimpan');
            //throw $th;
        }
    }

    public function export()
    {
        return Excel::download(new AlumniExport, 'Data Alumni Per Tanggal ' . date('d-m-Y') . '.xlsx');
    }
}
