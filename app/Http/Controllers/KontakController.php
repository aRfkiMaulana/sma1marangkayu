<?php

namespace App\Http\Controllers;

use App\Models\Pesan;
use App\Models\ProfilSekolah;
use Illuminate\Http\Request;

class KontakController extends Controller
{
    public function index()
    {
        $profil = ProfilSekolah::first();
        return view('public.kontak.index', compact('profil'));
    }

    public function kirim(Request $request)
    {
        $request->validate([
            'nama'    => 'required|string|max:100',
            'email'   => 'required|email|max:100',
            'telepon' => 'nullable|string|max:20',
            'subjek'  => 'required|string|max:150',
            'pesan'   => 'required|string|max:2000',
        ], [
            'nama.required'  => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
            'subjek.required' => 'Subjek wajib diisi.',
            'pesan.required' => 'Isi pesan wajib diisi.',
        ]);

        Pesan::create($request->only('nama', 'email', 'telepon', 'subjek', 'pesan'));

        return redirect()->route('kontak')->with('success', 'Pesan Anda telah berhasil dikirim. Kami akan segera merespons.');
    }
}
