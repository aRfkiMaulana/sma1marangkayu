<?php

namespace App\Http\Controllers;

use App\Models\Galeri;

class GaleriController extends Controller
{
    public function index()
    {
        $galeri = Galeri::where('tipe', 'foto')->orWhereNull('tipe')->orderBy('urutan')->paginate(12);
        $album  = Galeri::select('album')->distinct()->whereNotNull('album')->pluck('album');
        return view('public.galeri.index', compact('galeri', 'album'));
    }

    public function album(string $album)
    {
        $galeri = Galeri::where('album', $album)
            ->where(fn($q) => $q->where('tipe', 'foto')->orWhereNull('tipe'))
            ->orderBy('urutan')->get();
        $semua  = Galeri::select('album')->distinct()->whereNotNull('album')->pluck('album');
        return view('public.galeri.album', compact('galeri', 'album', 'semua'));
    }
}
