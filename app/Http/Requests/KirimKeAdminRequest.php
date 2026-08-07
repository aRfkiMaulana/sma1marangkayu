<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KirimKeAdminRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nisn'      => 'required|string|digits:10',
            'kode_unik' => 'required|string',
        ];
    }
}
