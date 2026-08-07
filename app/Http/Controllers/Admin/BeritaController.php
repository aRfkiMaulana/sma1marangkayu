<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Berita;
use App\Models\KategoriBerita;
use App\Services\HtmlSanitizer;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    public function index()
    {
        $berita = Berita::with('kategori')->latest()->paginate(15);
        return view('admin.berita.index', compact('berita'));
    }

    public function create()
    {
        $kategori = KategoriBerita::all();
        return view('admin.berita.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'              => 'required|string|max:255',
            'kategori_berita_id' => 'nullable|exists:kategori_berita,id',
            'konten'             => 'required',
            'tipe'               => 'required|in:berita,pengumuman,agenda',
            'status'             => 'required|in:draft,published',
            'tanggal_publish'    => 'nullable|date',
            'thumbnail'          => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['judul', 'kategori_berita_id', 'konten', 'tipe', 'status', 'tanggal_publish']);
        $data['konten']  = HtmlSanitizer::clean($data['konten']);
        $data['slug']    = Str::slug($validated['judul']) . '-' . time();
        $data['user_id'] = auth()->id();

        if ($validated['status'] === 'published' && empty($data['tanggal_publish'])) {
            $data['tanggal_publish'] = now();
        }

        try {
            DB::beginTransaction();

            if ($request->hasFile('thumbnail')) {
                $data['thumbnail'] = ImageService::uploadWebp($request->file('thumbnail'), 'berita');
            }

            $berita = Berita::create($data);
            ActivityLog::log('create', 'Berita', "Menambahkan berita: {$berita->judul}");

            DB::commit();
            return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($data['thumbnail'])) {
                Storage::disk('public')->delete($data['thumbnail']);
            }
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit(Berita $berita)
    {
        $kategori = KategoriBerita::all();
        return view('admin.berita.edit', compact('berita', 'kategori'));
    }

    public function update(Request $request, Berita $berita)
    {
        $validated = $request->validate([
            'judul'              => 'required|string|max:255',
            'kategori_berita_id' => 'nullable|exists:kategori_berita,id',
            'konten'             => 'required',
            'tipe'               => 'required|in:berita,pengumuman,agenda',
            'status'             => 'required|in:draft,published',
            'tanggal_publish'    => 'nullable|date',
            'thumbnail'          => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['judul', 'kategori_berita_id', 'konten', 'tipe', 'status', 'tanggal_publish']);
        $data['konten'] = HtmlSanitizer::clean($data['konten']);

        if ($validated['status'] === 'published' && !$berita->tanggal_publish && empty($data['tanggal_publish'])) {
            $data['tanggal_publish'] = now();
        }

        try {
            DB::beginTransaction();

            if ($request->hasFile('thumbnail')) {
                $data['thumbnail'] = ImageService::uploadWebp($request->file('thumbnail'), 'berita');
            }

            $berita->update($data);
            ActivityLog::log('update', 'Berita', "Mengubah berita: {$berita->judul}");

            // Delete old file only if DB update succeeds and new file is uploaded
            if ($request->hasFile('thumbnail') && $berita->getOriginal('thumbnail')) {
                Storage::disk('public')->delete($berita->getOriginal('thumbnail'));
            }

            DB::commit();
            return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($data['thumbnail']) && $request->hasFile('thumbnail')) {
                Storage::disk('public')->delete($data['thumbnail']);
            }
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(Berita $berita)
    {
        try {
            DB::beginTransaction();
            $thumbnail = $berita->thumbnail;

            $judul = $berita->judul;
            $berita->delete();
            ActivityLog::log('delete', 'Berita', "Menghapus berita: {$judul}");

            if ($thumbnail) {
                Storage::disk('public')->delete($thumbnail);
            }

            DB::commit();
            return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
