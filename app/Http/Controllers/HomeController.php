<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Galeri;
use App\Models\ProfilSekolah;
use App\Models\Slider;
use App\Models\Prestasi;

class HomeController extends Controller
{
    public function index()
    {
        $profil  = ProfilSekolah::first();
        $sliders = Slider::where('is_aktif', true)->orderBy('urutan')->get();
        $berita  = Berita::published()->latest('tanggal_publish')->take(6)->get();
        $galeri  = Galeri::where('is_highlight', true)->orderBy('urutan')->take(8)->get();
        $prestasi = Prestasi::latest()->take(4)->get();

        return view('public.home', compact('profil', 'sliders', 'berita', 'galeri', 'prestasi'));
    }
}
