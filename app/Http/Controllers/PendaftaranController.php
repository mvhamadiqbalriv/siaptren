<?php

namespace App\Http\Controllers;

use App\Http\Requests\PendaftaranRequest;
use App\Models\Master\FileUpload;
use App\Models\Master\OrangTuaWali;
use App\Models\Master\Santri;
use App\Models\User;
use App\Notifications\PendaftaranNotification;
use App\Services\FpdfHtmlService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;

class PendaftaranController extends Controller
{
    public function index()
    {
        return view('pendaftaran.form');
    }

    public function daftar(PendaftaranRequest $request)
    {
        DB::beginTransaction();
        try {
            $santri = Santri::create([
                'kode_santri' => generateKode('santri', 'kode_santri', 'ST' . date('ym')),
                'nama_lengkap' => $request->nama_lengkap,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tanggal_lahir' => reverseDate($request->tanggal_lahir),
                'tempat_lahir' => $request->tempat_lahir,
                'nomor_handphone' => $request->nomor_handphone,
                'email' => $request->alamat_email,
                'universitas' => $request->universitas,
                'fakultas' => $request->fakultas,
                'prodi' => $request->program_studi,
                'semester' => $request->semester,
                'alamat' => $request->alamat,
                'tahun_masuk' => date('Y')
            ]);

            $data_orang_tua = [];
            $data_orang_tua[] = [
                'santri_id' => $santri->id,
                'nama' => $request->nama_ayah,
                'pekerjaan' => $request->pekerjaan_ayah,
                'nomor_handphone' => $request->nomor_telepon_ayah ?? '',
                'alamat' => $request->alamat_orangtua,
                'status_keluarga' => 'Ayah'
            ];
            $data_orang_tua[] = [
                'santri_id' => $santri->id,
                'nama' => $request->nama_ibu,
                'pekerjaan' => $request->pekerjaan_ibu,
                'nomor_handphone' => $request->nomor_telepon_ibu ?? '',
                'alamat' => $request->alamat_orangtua,
                'status_keluarga' => 'Ibu'
            ];

            if ($request->nama_wali and $request->pekerjaan_wali and $request->nomor_telepon_wali) {
                $data_orang_tua[] = [
                    'santri_id' => $santri->id,
                    'nama' => $request->nama_wali,
                    'pekerjaan' => $request->pekerjaan_wali,
                    'nomor_handphone' => $request->nomor_telepon_wali ?? '',
                    'alamat' => $request->alamat_wali,
                    'status_keluarga' => 'Wali'
                ];
            }
            OrangTuaWali::insert($data_orang_tua);

            $keys = ['ktp' => 'KTP', 'kk' => 'KK', 'foto' => 'Foto'];
            $insert_upload = [];
            foreach ($keys as $key => $jenis) {

                $file = $request->file($key);
                $filename = time() . rand() . '.' . $file->getClientOriginalExtension();
                $path = storage_path('app/public/uploads');
                if (!File::exists($path)) {
                    File::makeDirectory($path);
                }
                $file->move($path, $filename);

                $insert_upload[] = [
                    'ref_id' => $santri->id,
                    'ref_tipe' => 'santri',
                    'jenis' => $jenis,
                    'nama_file' => $filename
                ];
            }
            FileUpload::insert($insert_upload);

            $admin = User::role('admin')->get();
            Notification::send($admin, new PendaftaranNotification($santri->kode_santri, "Pendaftaran santri baru atas nama $santri->nama_lengkap"));

            DB::commit();
            return response()->json([
                'status' => 'success',
                'kode' => encrypt($santri->kode_santri)
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return responseMessage('error', $th->getMessage());
        }
    }

    public function success($kode)
    {
        try {
            $santri = Santri::where('kode_santri', decrypt($kode))->first();
            return view('pendaftaran.success', compact('santri'));
        } catch (\Throwable $th) {
            return response('Salah parameter', 500);
        }
    }

    public function downloadByEmail(Request $request)
    {
        $request->validate([
            'email' => 'required'
        ]);
        try {
            $santri = Santri::where('email', $request->email)->first();
            if (!$santri) {
                throw new Exception('Email anda tidak terdaftar');
            }

            return response()->json([
                'status' => 'success',
                'id' => encrypt($santri->kode_santri)
            ]);
        } catch (\Throwable $th) {
            return responseMessage('error', $th->getMessage());
        }
    }

    public function download($kode, FpdfHtmlService $pdf)
    {
        $kode = decrypt($kode);
        $santri = Santri::with(['ayah', 'ibu', 'wali', 'pasFoto'])->where('kode_santri', $kode)->first();

        $pdf->AddPage('', 'legal');
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->SetTopMargin(30);
        $pdf->Cell($pdf->GetPageWidth() - 10, 0, 'FORMULIR PENDAFTARAN', 0, 0, 'C');
        $pdf->Image(public_path('storage/uploads') . '/' . $santri->pasFoto->nama_file, 97, 20, 30, 40);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetXY(19, $pdf->GetY() + 65);
        $pdf->Cell($pdf->GetPageWidth() - 10, 0, 'A. Data Diri', 0, 0, 'L');

        $pdf->SetFont('Arial', '', 10);

        $data = [
            'Kode Santri' => $santri->kode_santri,
            'Nama Lengkap' => $santri->nama_lengkap,
            'Jenis Kelamin' => $santri->jenis_kelamin == 'L' ? 'LAKI-LAKI' : 'PEREMPUAN',
            'Tanggal Lahir' => $santri->tempat_lahir . strtoupper(dateFormat($santri->tanggal_lahir, ', d F Y')),
            'Universitas' => $santri->universitas,
            'Fakultas' => $santri->fakultas,
            'Program Studi' => $santri->prodi,
            'Semester' => $santri->semester,
            'Nomor Handphone' => $santri->nomor_handphone,
            'Alamat Email' => $santri->email,
            'multicell Alamat' => $santri->alamat
        ];

        $no = 0;
        $line = 7;
        foreach ($data as $key => $value) {
            $no++;
            if ($no == 1) {
                $pdf->SetXY(25, $pdf->GetY());
            }
            if (strtolower(explode(' ', $key)[0]) == 'multicell') {
                $key = trim(str_replace('multicell', '', $key));
                $pdf->SetXY(25, $pdf->GetY() + $line);
                $pdf->cell(40, 0, $key, 0, 0, 'L');
                $pdf->cell(5, 0, ':', 0, 0, 'C');
                $pdf->setXY(70, $pdf->GetY() - 2);
                $pdf->MultiCell(110, 5, $value, '', 'J');
                $pdf->SetXY(25, $pdf->GetY() - 2);
            } else {
                $pdf->SetXY(25, $pdf->GetY() + $line);
                $pdf->cell(40, 0, $key, 0, 0, 'L');
                $pdf->cell(5, 0, ':', 0, 0, 'C');
                $pdf->cell(110, 0, $value, 0, 0, 'L');
            }
        }

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetXY(19, $pdf->GetY() + 15);
        $pdf->Cell($pdf->GetPageWidth() - 10, 0, 'B. Data Orangtua/Wali', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 10);
        $data = [
            'Nama Ayah' => $santri->ayah->nama,
            'Pekerjaan Ayah' => $santri->ayah->pekerjaan,
            'Nomor Telepon Ayah' => $santri->ayah->nomor_handphone ?? '-',
            'Nama Ibu' => $santri->ibu->nama,
            'Pekerjaan Ibu' => $santri->ibu->pekerjaan,
            'Nomor Telepon Ibu' => $santri->ibu->nomor_handphone ?? '-',
            'Alamat' => $santri->ibu->alamat
        ];

        if ($santri->wali) {
            $data['Nama Wali'] = $santri->wali->nama;
            $data['Pekerjaan Wali'] = $santri->wali->pekerjaan;
            $data['Nomor Telepon Wali'] = $santri->wali->nomor_handphone;
            $data['multicell Alamat Wali'] = $santri->wali->alamat;
        }

        $no = 0;
        $line = 7;
        foreach ($data as $key => $value) {
            $no++;
            if ($no == 1) {
                $pdf->SetXY(25, $pdf->GetY());
            }
            if (strtolower(explode(' ', $key)[0]) == 'multicell') {
                $key = trim(str_replace('multicell', '', $key));
                $pdf->SetXY(25, $pdf->GetY() + $line);
                $pdf->cell(40, 0, $key, 0, 0, 'L');
                $pdf->cell(5, 0, ':', 0, 0, 'C');
                $pdf->setXY(70, $pdf->GetY() - 2);
                $pdf->MultiCell(110, 5, $value, '', 'J');
                $pdf->SetXY(25, $pdf->GetY() - 2);
            } else {
                $pdf->SetXY(25, $pdf->GetY() + $line);
                $pdf->cell(40, 0, $key, 0, 0, 'L');
                $pdf->cell(5, 0, ':', 0, 0, 'C');
                $pdf->cell(110, 0, $value, 0, 0, 'L');
            }
        }

        $pdf->SetFont('Courier', '', 8);
        $pdf->setXY(25, $pdf->GetY() + 10);
        $pdf->cell(165, 5, "Tanggal Daftar: " . date('d-m-Y, H:i:s', strtotime($santri->created_at)), '', 0, 'R', 0);
        $pdf->setXY(25, $pdf->GetY() + 5);
        $pdf->cell(165, 5, "Dicetak Tanggal: " . date('d-m-Y, H:i:s'), '', 0, 'R', 0);

        $pdf->Output('I', "FORMULIR $kode.pdf");
        exit;
    }
}
