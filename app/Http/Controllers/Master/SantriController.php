<?php

namespace App\Http\Controllers\Master;

use App\DataTables\SantriDataTable;
use App\Exports\SantriExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\SantriRequest;
use App\Models\Master\FileUpload;
use App\Models\Master\Santri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class SantriController extends Controller
{
    public function index(SantriDataTable $datatable)
    {
        return $datatable->render('master.santri');
    }

    public function show($id)
    {
        $data = Santri::with(['pasFoto', 'kk', 'ktp'])->where('kode_santri', decrypt($id))->first();
        if ($data) {
            if (request('verifikasi')) {
                $url = route('santri.verifikasi', $id);
                return view('master.santri-detail', compact('data', 'url'));
            }
            return view('master.santri-detail', compact('data'));
        }
        return responseMessage('error', 'Data tidak ditemukan');
    }

    public function edit($id)
    {
        $data = Santri::where('kode_santri', decrypt($id))->first();
        if ($data) {
            return view('master.santri-form', compact('data'));
        }
        return responseMessage('error', 'Data tidak ditemukan');
    }

    public function update(SantriRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $data = Santri::where('kode_santri', decrypt($id))->first();
            $data->nama_lengkap = strtoupper($request->nama_lengkap);
            $data->jenis_kelamin = strtoupper($request->jenis_kelamin);
            $data->tempat_lahir = strtoupper($request->tempat_lahir);
            $data->tanggal_lahir = reverseDate($request->tanggal_lahir);
            $data->nomor_handphone = $request->nomor_handphone;
            $data->email = $request->email;
            $data->alamat = strtoupper($request->alamat);
            $data->universitas = strtoupper($request->universitas);
            $data->fakultas = strtoupper($request->fakultas);
            $data->prodi = strtoupper($request->program_studi);
            $data->semester = $request->semester;
            if ($request->lulus) {
                $data->status = 'Lulus';
                $data->tahun_lulus = $request->tahun_lulus;
                $data->pekerjaan = $request->pekerjaan;
            }
            $data->user_update = $request->user()->username;
            $data->save();

            DB::commit();
            return responseMessage();
        } catch (\Throwable $th) {
            DB::rollBack();
            return responseMessage('error', $th->getMessage());
        }
    }

    public function verifikasi(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Y,N'
        ]);

        DB::beginTransaction();
        try {
            $data = Santri::where('kode_santri', decrypt($id))->first();
            $data->status = $request->status == 'Y' ? 'Aktif' : null;
            if ($request->status) {
                $data->user_verifikasi = $request->user()->username;
            }

            $data->save();

            DB::commit();
            return responseMessage();
        } catch (\Throwable $th) {
            DB::rollBack();
            return responseMessage('error', $th->getMessage());
        }
    }

    public function export()
    {
        return Excel::download(new SantriExport, 'Daftar Santri Per Tanggal ' . date('d-m-Y') . '.xlsx');
    }

    public function upload(Request $request, $id)
    {
        $data = Santri::with(['pasFoto', 'kk', 'ktp'])->where('kode_santri', decrypt($id))->first();
        if ($data) {
            if ($request->method() == 'GET') {
                $url = route('santri.upload', $id);
                return view('master.santri-upload', compact('data', 'url'));
            }

            $request->validate([
                'ktp' => Rule::requiredIf(function () {
                    return !request('ktp_old');
                }),
                'kk' => Rule::requiredIf(function () {
                    return !request('kk_old');
                }),
                'foto' => Rule::requiredIf(function () {
                    return !request('foto_old');
                })
            ]);

            DB::beginTransaction();
            try {
                $keys = ['ktp' => 'KTP', 'kk' => 'KK', 'foto' => 'Foto'];
                $relations = ['ktp' => 'ktp', 'kk' => 'kk', 'foto' => 'pasFoto'];
                $insert_upload = [];
                foreach ($keys as $key => $jenis) {
                    if ($request->file($key)) {
                        $file = $request->file($key);
                        $filename = time() . rand() . '.' . $file->getClientOriginalExtension();
                        $path = storage_path('app/public/uploads');
                        if (!File::exists($path)) {
                            File::makeDirectory($path);
                        }

                        $method = $relations[$key];
                        if ($data->$method) {
                            if (File::exists($path . "/" . $data->$method->nama_file)) {
                                File::delete($path . "/" . $data->$method->nama_file);
                            }
                        }
                        
                        FileUpload::where([
                            'ref_id' => $data->id,
                            'ref_tipe' => 'santri',
                            'jenis' => $jenis
                        ])->delete();

                        $file->move($path, $filename);

                        $insert_upload[] = [
                            'ref_id' => $data->id,
                            'ref_tipe' => 'santri',
                            'jenis' => $jenis,
                            'nama_file' => $filename
                        ];
                    }
                }

                if (count($insert_upload)) {
                    FileUpload::insert($insert_upload);
                }

                DB::commit();
                return responseMessage();
            } catch (\Throwable $th) {
                DB::rollBack();
                return responseMessage('error', 'Upload berkas gagal');
            }
        }
        return responseMessage('error', 'Data tidak ditemukan');
    }
}
