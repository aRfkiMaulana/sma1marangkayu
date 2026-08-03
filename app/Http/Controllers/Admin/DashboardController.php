<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\GuruStaf;
use App\Models\Pesan;
use App\Models\Galeri;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'berita'    => Berita::count(),
            'guru'      => GuruStaf::where('tipe', 'guru')->count(),
            'staf'      => GuruStaf::where('tipe', 'staf')->count(),
            'galeri'    => Galeri::count(),
            'pesan_baru' => Pesan::where('is_read', false)->count(),
        ];
        $berita_terbaru = Berita::latest()->take(5)->get();
        $pesan_terbaru  = Pesan::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'berita_terbaru', 'pesan_terbaru'));
    }
}
