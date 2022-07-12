<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            'jabatan' => 'required',
            'email' => [
                'required',
                Rule::unique('users', 'email')->ignore(request('id'), 'id')
            ],
            'no_hp' => 'required',
            'username' => [
                Rule::requiredIf(function () {
                    return !request('id');
                }),
                Rule::unique('users', 'username')->ignore(request('id'), 'id')
            ],
            'password' => [
                Rule::requiredIf(function () {
                    return !request('id');
                }),
                'confirmed'
            ]
        ];
    }
}
