<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AsatidzRequest extends FormRequest
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
        if (request()->user()->hasRole('bendahara')) {
            return ['upah_pertemuan' => 'required'];
        }

        return [
            'nik' => 'required|numeric|digits:16',
            'nama_lengkap' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'upah_pertemuan' => 'required'
        ];
    }
}
