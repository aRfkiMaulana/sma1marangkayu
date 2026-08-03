<?php

namespace App\Http\Controllers;

use App\Models\Galeri;

class GaleriController extends Controller
{
    public function index()
    {
        $galeri = Galeri::orderBy('urutan')->paginate(12);
        $album  = Galeri::select('album')->distinct()->whereNotNull('album')->pluck('album');
        return view('public.galeri.index', compact('galeri', 'album'));
    }

    public function album(string $album)
    {
        $galeri    = Galeri::where('album', $album)->orderBy('urutan')->get();
        $semua     = Galeri::select('album')->distinct()->whereNotNull('album')->pluck('album');
        return view('public.galeri.album', compact('galeri', 'album', 'semua'));
    }
}
