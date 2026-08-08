<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Akademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KurikulumController extends Controller
{
    public function edit()
    {
        $kurikulum = Akademik::where('tipe', 'kurikulum')->first();
        return view('admin.kurikulum.edit', compact('kurikulum'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'judul'          => 'required|string|max:255',
            'subjudul'       => 'nullable|string|max:500',
            'konten'         => 'required|string',
            'tujuan'         => 'nullable|array',
            'tujuan.*.judul' => 'nullable|string|max:255',
            'tujuan.*.desc'  => 'nullable|string|max:500',
            'struktur'       => 'nullable|array',
            'struktur.*'     => 'nullable|string|max:500',
            'fakta'          => 'nullable|array',
            'fakta.*.label'  => 'nullable|string|max:255',
            'fakta.*.value'  => 'nullable|string|max:255',
            'tahapan'        => 'nullable|array',
            'tahapan.*.judul'=> 'nullable|string|max:255',
            'tahapan.*.desc' => 'nullable|string|max:500',
            'file_lampiran'  => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $kurikulum = Akademik::firstOrCreate(
            ['tipe' => 'kurikulum'],
            ['judul' => $request->judul, 'konten' => $request->konten]
        );

        $metaData = [
            'subjudul' => $request->subjudul,
            'tujuan'   => array_values(array_filter($request->input('tujuan', []), fn($t) => !empty($t['judul']))),
            'struktur' => array_values(array_filter($request->input('struktur', []), fn($s) => !empty(trim($s)))),
            'fakta'    => array_values(array_filter($request->input('fakta', []), fn($f) => !empty($f['label']))),
            'tahapan'  => array_values(array_filter($request->input('tahapan', []), fn($th) => !empty($th['judul']))),
        ];

        $data = [
            'judul'     => $request->judul,
            'konten'    => $request->konten,
            'meta_data' => $metaData,
        ];

        if ($request->hasFile('file_lampiran')) {
            if ($kurikulum->file_lampiran) {
                Storage::disk('public')->delete($kurikulum->file_lampiran);
            }
            $data['file_lampiran'] = $request->file('file_lampiran')->store('kurikulum', 'public');
        }

        $kurikulum->update($data);

        return redirect()->route('admin.kurikulum.edit')->with('success', 'Seluruh pengaturan halaman Kurikulum berhasil diperbarui.');
    }
}
