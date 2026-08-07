<?php

namespace App\Http\Requests;

use App\Models\Siswa;
use Illuminate\Foundation\Http\FormRequest;

class SubmitSiswaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $siswa = Siswa::where('nisn', $this->nisn)->first();
        $isFotoRequired = !$siswa || in_array($siswa->status, ['kosong', 'draft']) && !$siswa->foto;

        return [
            'nisn'      => 'required|string|digits:10',
            'kode_unik' => 'required|string',
            'foto'      => ($isFotoRequired ? 'required|' : 'nullable|') . 'image|mimes:jpg,jpeg,png|max:2048|dimensions:min_width=400,min_height=400',
            'moto'      => 'required|string|max:255',
        ];
    }
}
