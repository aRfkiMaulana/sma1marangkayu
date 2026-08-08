<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Akademik;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KalenderAkademikController extends Controller
{
    public function index()
    {
        $kalender = Akademik::where('tipe', 'kalender')->first();
        return view('admin.kalender.index', compact('kalender'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|max:5120',
        ]);

        $kalender = Akademik::firstOrCreate(
            ['tipe' => 'kalender'],
            [
                'judul'  => 'Kalender Akademik',
                'konten' => 'Kalender Akademik SMAN 1 Marangkayu',
            ]
        );

        if ($request->hasFile('foto')) {
            if ($kalender->file_lampiran) {
                Storage::disk('public')->delete($kalender->file_lampiran);
            }
            $kalender->file_lampiran = ImageService::uploadWebp($request->file('foto'), 'kalender', 90);
        }

        $kalender->is_aktif = true;
        $kalender->save();

        return redirect()->route('admin.kalender.index')->with('success', 'Foto Kalender Akademik berhasil diperbarui.');
    }
}
