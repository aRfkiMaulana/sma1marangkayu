<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Ekstrakurikuler;
use App\Models\Galeri;
use App\Models\ProfilSekolah;
use App\Models\Slider;
use App\Models\Prestasi;

class HomeController extends Controller
{
    public function index()
    {
        $profil  = ProfilSekolah::first() ?? new ProfilSekolah();
        $sliders = Slider::where('is_aktif', true)->orderBy('urutan')->get();
        $berita  = Berita::published()->with(['kategori', 'penulis'])->latest('tanggal_publish')->take(6)->get();
        $galeri  = Galeri::where('is_highlight', true)->orderBy('urutan')->take(8)->get();
        $prestasi = Prestasi::latest()->take(4)->get();

        // ── Chart: Peringkat Ekstrakurikuler (doughnut) ──────────────────────
        $bobot = [
            'internasional' => 100,
            'nasional'      => 75,
            'provinsi'      => 50,
            'kabupaten'     => 30,
            'kecamatan'     => 20,
            'sekolah'       => 10,
        ];

        $ekskulChart = Ekstrakurikuler::with('prestasi')
            ->where('is_aktif', true)
            ->get()
            ->map(fn($e) => [
                'nama' => $e->nama,
                'skor' => $e->prestasi->sum(fn($p) => $bobot[$p->tingkat] ?? 0),
            ])
            ->filter(fn($e) => $e['skor'] > 0)
            ->sortByDesc('skor')
            ->take(6)
            ->values();

        // ── Chart: Berita & Galeri (bar) ─────────────────────────────────────
        $beritaGaleriChart = collect([
            'Berita'      => Berita::published()->count(),
            'Pengumuman'  => Berita::published()->where('tipe', 'pengumuman')->count(),
            'Agenda'      => Berita::published()->where('tipe', 'agenda')->count(),
            'Galeri'      => Galeri::count(),
        ]);

        return view('public.home', compact(
            'profil', 'sliders', 'berita', 'galeri', 'prestasi',
            'ekskulChart', 'beritaGaleriChart'
        ));
    }
}
