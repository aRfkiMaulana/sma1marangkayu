<?php

namespace App\Http\Requests;

use App\Rules\Turnstile;
use Illuminate\Foundation\Http\FormRequest;

class SiswaClaimRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nisn'                   => 'required|string|exists:siswas,nisn',
            'kode_unik'              => 'required|string',
            'foto'                   => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'moto'                   => 'required|string|max:500',
            'cf-turnstile-response'  => ['required', 'string', new Turnstile()],
        ];
    }
}
