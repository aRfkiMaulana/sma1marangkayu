<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\KategoriBerita;
use Illuminate\Http\Request;
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
        $request->validate([
            'judul'     => 'required|string|max:255',
            'konten'    => 'required',
            'tipe'      => 'required|in:berita,pengumuman,agenda',
            'status'    => 'required|in:draft,published',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        $data              = $request->except(['_token', 'thumbnail']);
        $data['slug']      = Str::slug($request->judul) . '-' . time();
        $data['user_id']   = auth()->id();

        if ($request->status === 'published' && !$request->tanggal_publish) {
            $data['tanggal_publish'] = now();
        }

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('berita', 'public');
        }

        Berita::create($data);
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(Berita $berita)
    {
        $kategori = KategoriBerita::all();
        return view('admin.berita.edit', compact('berita', 'kategori'));
    }

    public function update(Request $request, Berita $berita)
    {
        $request->validate([
            'judul'     => 'required|string|max:255',
            'konten'    => 'required',
            'tipe'      => 'required|in:berita,pengumuman,agenda',
            'status'    => 'required|in:draft,published',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        $data = $request->except(['_token', '_method', 'thumbnail']);

        if ($request->status === 'published' && !$berita->tanggal_publish && !$request->tanggal_publish) {
            $data['tanggal_publish'] = now();
        }

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('berita', 'public');
        }

        $berita->update($data);
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Berita $berita)
    {
        $berita->delete();
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus.');
    }
}
