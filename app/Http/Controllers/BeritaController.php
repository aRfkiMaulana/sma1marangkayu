<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\KategoriBerita;

class BeritaController extends Controller
{
    public function index()
    {
        $berita    = Berita::published()->with(['kategori', 'penulis'])->latest('tanggal_publish')->paginate(9);
        $kategori  = KategoriBerita::withCount(['berita' => fn($q) => $q->published()])->get();
        $terkini   = Berita::published()->with('kategori')->latest('tanggal_publish')->take(5)->get();
        return view('public.berita.index', compact('berita', 'kategori', 'terkini'));
    }

    public function show(Berita $berita)
    {
        abort_if($berita->status !== 'published', 404);
        $berita->load(['kategori', 'penulis']);
        $berita->increment('views');
        $related = Berita::published()
            ->with(['kategori', 'penulis'])
            ->where('id', '!=', $berita->id)
            ->where('kategori_id', $berita->kategori_id)
            ->take(3)->get();
        return view('public.berita.show', compact('berita', 'related'));
    }

    public function kategori(KategoriBerita $kategori)
    {
        $berita  = $kategori->berita()->published()->with(['kategori', 'penulis'])->latest('tanggal_publish')->paginate(9);
        $semua   = KategoriBerita::withCount(['berita' => fn($q) => $q->published()])->get();
        return view('public.berita.kategori', compact('berita', 'kategori', 'semua'));
    }
}
