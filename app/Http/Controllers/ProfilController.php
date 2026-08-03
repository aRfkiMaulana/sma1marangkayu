<?php

namespace App\Http\Controllers;

use App\Models\ProfilSekolah;
use App\Models\GuruStaf;
use App\Models\Fasilitas;

class ProfilController extends Controller
{
    public function sejarah()
    {
        $profil = ProfilSekolah::first();
        return view('public.profil.sejarah', compact('profil'));
    }

    public function visiMisi()
    {
        $profil = ProfilSekolah::first();
        return view('public.profil.visi-misi', compact('profil'));
    }

    public function strukturOrganisasi()
    {
        $guru = GuruStaf::where('tipe', 'guru')->where('is_aktif', true)->orderBy('urutan')->get();
        $staf = GuruStaf::where('tipe', 'staf')->where('is_aktif', true)->orderBy('urutan')->get();
        return view('public.profil.struktur-organisasi', compact('guru', 'staf'));
    }

    public function fasilitas()
    {
        $fasilitas = Fasilitas::where('is_aktif', true)->orderBy('urutan')->get();
        $kategori  = $fasilitas->pluck('kategori')->unique()->filter();
        return view('public.profil.fasilitas', compact('fasilitas', 'kategori'));
    }
}
