<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class KelasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_kelas'  => 'required|string|max:50',
            'angkatan_id' => 'required|exists:angkatan,id',
        ];
    }
}
