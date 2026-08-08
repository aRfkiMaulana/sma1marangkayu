<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfilSekolah;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'nama_sekolah'   => 'required|string|max:200',
            'npsn'           => 'nullable|string|max:50',
            'akreditasi'     => 'nullable|string|max:10',
            'kepala_sekolah' => 'nullable|string|max:150',
            'visi'           => 'nullable|string',
            'misi'           => 'nullable|string',
            'sejarah'        => 'nullable|string',
            'alamat'         => 'nullable|string',
            'kecamatan'      => 'nullable|string|max:100',
            'kabupaten'      => 'nullable|string|max:100',
            'provinsi'       => 'nullable|string|max:100',
            'telepon'        => 'nullable|string|max:50',
            'email'          => 'nullable|email|max:100',
            'jumlah_siswa'   => 'nullable|integer',
            'jumlah_guru'    => 'nullable|integer',
            'jumlah_staf'    => 'nullable|integer',
            'tahun_berdiri'  => 'nullable|integer',
            'maps_embed'     => 'nullable|string',
            'logo'           => 'nullable|image|max:2048',
            'foto_sekolah'   => 'nullable|image|max:4096',
        ]);

        $profil = ProfilSekolah::firstOrNew([]);
        $data   = $request->only([
            'nama_sekolah', 'npsn', 'akreditasi', 'kepala_sekolah', 'visi', 'misi',
            'sejarah', 'alamat', 'kecamatan', 'kabupaten', 'provinsi', 'kode_pos', 'telepon', 'whatsapp',
            'email', 'website', 'facebook', 'instagram', 'youtube',
            'jumlah_siswa', 'jumlah_guru', 'jumlah_staf', 'tahun_berdiri', 'maps_embed'
        ]);

        if ($request->hasFile('logo')) {
            if ($profil->logo) {
                Storage::disk('public')->delete($profil->logo);
            }
            $data['logo'] = ImageService::uploadWebp($request->file('logo'), 'profil');
        }

        if ($request->hasFile('foto_sekolah')) {
            if ($profil->foto_sekolah) {
                Storage::disk('public')->delete($profil->foto_sekolah);
            }
            $data['foto_sekolah'] = ImageService::uploadWebp($request->file('foto_sekolah'), 'profil');
        }

        $profil->fill($data)->save();

        return redirect()->route('admin.profil.edit')->with('success', 'Profil sekolah berhasil diperbarui.');
    }
}
