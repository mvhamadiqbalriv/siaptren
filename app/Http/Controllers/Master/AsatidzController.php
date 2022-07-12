<?php

namespace App\Http\Controllers\Master;

use App\DataTables\AsatidzDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\AsatidzRequest;
use App\Models\Master\Asatidz;
use App\Models\Master\FileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class AsatidzController extends Controller
{
    public function index(AsatidzDataTable $datatable)
    {
        return $datatable->render('master.asatidz');
    }

    public function create()
    {
        return view('master.asatidz-form');
    }

    public function store(AsatidzRequest $request)
    {
        DB::beginTransaction();
        try {
            Asatidz::create([
                'kode_asatidz' => generateKode('asatidz', 'kode_asatidz', "UST" . date('ym')),
                'nik' => $request->nik,
                'nama_lengkap' => strtoupper($request->nama_lengkap),
                'tempat_lahir' => strtoupper($request->tempat_lahir),
                'tanggal_lahir' => reverseDate($request->tanggal_lahir),
                'upah_pertemuan' => preg_replace('/\D/', '', $request->upah_pertemuan)
            ]);

            DB::commit();
            return responseMessage();
        } catch (\Throwable $th) {
            DB::rollBack();
            return responseMessage('error', $th->getMessage());
        }
    }

    public function show($id)
    {
        $data = Asatidz::with(['pasFoto', 'kk', 'ktp'])->where('kode_asatidz', decrypt($id))->first();
        if ($data) {
            $data->tanggal_lahir = reverseDate($data->tanggal_lahir);
            return view('master.asatidz-detail', compact('data'));
        }
        return responseMessage('error', 'Data tidak ditemukan');
    }

    public function edit($id)
    {
        $data = Asatidz::where('kode_asatidz', decrypt($id))->first();
        if ($data) {
            $url = route('asatidz.update', $id);
            $data->tanggal_lahir = reverseDate($data->tanggal_lahir);
            return view('master.asatidz-form', compact('data', 'url'));
        }
        return responseMessage('error', 'Data tidak ditemukan');
    }


    public function update(AsatidzRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $data = Asatidz::where('kode_asatidz', decrypt($id))->first();
            if ($request->user()->hasRole('admin')) {
                $data->nik = $request->nik;
                $data->nama_lengkap = strtoupper($request->nama_lengkap);
                $data->tempat_lahir = strtoupper($request->tempat_lahir);
                $data->tanggal_lahir = reverseDate($request->tanggal_lahir);
                $data->aktif = $request->aktif ? 1 : 0;
            }
            $data->upah_pertemuan = preg_replace('/\D/', '', $request->upah_pertemuan);
            $data->save();

            DB::commit();
            return responseMessage();
        } catch (\Throwable $th) {
            DB::rollBack();
            return responseMessage('error', $th->getMessage());
        }
    }

    public function upload(Request $request, $id)
    {
        $data = Asatidz::with(['pasFoto', 'kk', 'ktp'])->where('kode_asatidz', decrypt($id))->first();
        if ($data) {
            if ($request->method() == 'GET') {
                $url = route('asatidz.upload', $id);
                return view('master.asatidz-upload', compact('data', 'url'));
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

                        $file->move($path, $filename);

                        $insert_upload[] = [
                            'ref_id' => $data->id,
                            'ref_tipe' => 'asatidz',
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
