<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ImportSiswaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file'     => 'required|file|mimes:xlsx,csv|max:2048',
            'kelas_id' => 'required|exists:kelas,id',
        ];
    }
}
