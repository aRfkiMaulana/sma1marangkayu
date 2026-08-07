<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SiswaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $siswaId = $this->route('siswa') ? $this->route('siswa')->id : null;

        return [
            'nama'        => 'required|string|max:255',
            'nisn'        => 'nullable|string|max:20|unique:siswas,nisn,' . $siswaId,
            'angkatan_id' => 'required|exists:angkatan,id',
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'moto'        => 'nullable|string|max:500',
            'status'      => 'nullable|in:kosong,pending,approved,rejected',
        ];
    }
}
