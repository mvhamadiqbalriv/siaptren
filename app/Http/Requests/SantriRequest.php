<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class SantriRequest extends FormRequest
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
        $rules = [
            'nama_lengkap' => 'required',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'nomor_handphone' => 'required',
            'email' => 'required|unique',
            'alamat' => 'required',
            'universitas' => 'required',
            'fakultas' => 'required',
            'program_studi' => 'required',
            'semester' => 'required',
        ];

        if (Route::currentRouteName() == 'santri.update') {
            $rules['tahun_lulus'] = Rule::requiredIf(function () {
                return request('lulus');
            });

            $id = decrypt(request()->segment(4));
            $rules['email'] = Rule::unique('santri', 'email')->ignore($id, 'kode_santri');
        }

        return $rules;
    }
}
