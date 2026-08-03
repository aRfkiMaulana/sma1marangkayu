<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfilSekolah;
use Illuminate\Http\Request;

class ProfilSekolahController extends Controller
{
    public function edit()
    {
        $profil = ProfilSekolah::firstOrNew([]);
        return view('admin.profil.edit', compact('profil'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_sekolah' => 'required|string|max:200',
            'email'        => 'nullable|email',
            'logo'         => 'nullable|image|max:2048',
            'foto_sekolah' => 'nullable|image|max:4096',
        ]);

        $profil = ProfilSekolah::firstOrNew([]);
        $data   = $request->except(['_token', '_method', 'logo', 'foto_sekolah']);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('profil', 'public');
        }
        if ($request->hasFile('foto_sekolah')) {
            $data['foto_sekolah'] = $request->file('foto_sekolah')->store('profil', 'public');
        }

        $profil->fill($data)->save();

        return redirect()->route('admin.profil.edit')->with('success', 'Profil sekolah berhasil diperbarui.');
    }
}
