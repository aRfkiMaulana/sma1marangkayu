<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AngkatanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_angkatan' => 'required|string|max:100',
            'tahun_lulus'   => 'required|integer|digits:4',
            'dibuka_at'     => 'nullable|date',
            'ditutup_at'    => 'nullable|date|after:dibuka_at',
        ];
    }
}
