<?php

namespace App\Http\Controllers;

use App\Models\Akademik;
use App\Models\Ekstrakurikuler;
use App\Models\Prestasi;

class AkademikController extends Controller
{
    public function kurikulum()
    {
        return view('public.akademik.kurikulum');
    }

    public function ekstrakurikuler()
    {
        $ekskul = Ekstrakurikuler::with('personel')->where('is_aktif', true)->get();
        return view('public.akademik.ekstrakurikuler', compact('ekskul'));
    }

    public function ekstrakurikulerShow(Ekstrakurikuler $ekstrakurikuler)
    {
        $ekstrakurikuler->load(['personel', 'prestasi']);
        $lainnya = Ekstrakurikuler::where('id', '!=', $ekstrakurikuler->id)
            ->where('is_aktif', true)
            ->limit(4)
            ->get();
        return view('public.akademik.ekstrakurikuler-show', compact('ekstrakurikuler', 'lainnya'));
    }

    public function kalender()
    {
        $data = Akademik::where('tipe', 'kalender')->where('is_aktif', true)->first();
        return view('public.akademik.kalender', compact('data'));
    }

    public function prestasi()
    {
        $prestasi  = Prestasi::with('ekstrakurikuler')->orderByDesc('tahun')->paginate(12);
        $tingkatan = ['sekolah', 'kecamatan', 'kabupaten', 'provinsi', 'nasional', 'internasional'];
        return view('public.akademik.prestasi', compact('prestasi', 'tingkatan'));
    }

    public function prestasiShow(Prestasi $prestasi)
    {
        $prestasi->load('ekstrakurikuler');
        $lainnya = Prestasi::where('id', '!=', $prestasi->id)
            ->orderByDesc('tahun')
            ->limit(4)
            ->get();
        return view('public.akademik.prestasi-show', compact('prestasi', 'lainnya'));
    }
}
