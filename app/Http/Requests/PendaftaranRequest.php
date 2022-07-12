<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PendaftaranRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nama_lengkap' => 'required',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'nomor_handphone' => 'required|numeric',
            'alamat_email' => 'required|email|unique:santri,email',
            'alamat' => 'required',
            'universitas' => 'required',
            'fakultas' => 'required',
            'program_studi' => 'required',
            'semester' => 'required',
            'nama_ayah' => 'required',
            'pekerjaan_ayah' => 'required',
            'nomor_telepon_ayah' => 'required_without:nomor_telepon_ibu',
            'nama_ibu' => 'required',
            'pekerjaan_ibu' => 'required',
            'nomor_telepon_ibu' => 'required_without:nomor_telepon_ayah',
            'alamat_orangtua' => 'required',
            'ktp' => 'required|image',
            'kk' => 'required|image',
            'foto' => 'required|image'
        ];
    }
}
