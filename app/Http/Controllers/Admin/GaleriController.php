<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    public function index()
    {
        $galeri = Galeri::orderBy('urutan')->paginate(20);
        return view('admin.galeri.index', compact('galeri'));
    }

    public function create()
    {
        return view('admin.galeri.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:200',
            'file'  => 'required|image|max:4096',
            'album' => 'nullable|string|max:100',
        ]);

        $data = $request->only(['judul', 'album', 'urutan', 'deskripsi']);
        $data['tipe']         = 'foto';
        $data['is_highlight'] = $request->boolean('is_highlight');
        $data['file']         = $request->file('file')->store('galeri', 'public');

        Galeri::create($data);
        return redirect()->route('admin.galeri.index')->with('success', 'Foto berhasil ditambahkan.');
    }

    public function edit(Galeri $galeri)
    {
        return view('admin.galeri.edit', compact('galeri'));
    }

    public function update(Request $request, Galeri $galeri)
    {
        $request->validate([
            'judul' => 'required|string|max:200',
            'file'  => 'nullable|image|max:4096',
            'album' => 'nullable|string|max:100',
        ]);

        $data = $request->only(['judul', 'album', 'urutan', 'deskripsi']);
        $data['is_highlight'] = $request->boolean('is_highlight');

        if ($request->hasFile('file')) {
            if ($galeri->file && $galeri->tipe === 'foto') {
                Storage::disk('public')->delete($galeri->file);
            }
            $data['file'] = $request->file('file')->store('galeri', 'public');
        }

        $galeri->update($data);
        return redirect()->route('admin.galeri.index')->with('success', 'Foto berhasil diperbarui.');
    }

    public function destroy(Galeri $galeri)
    {
        if ($galeri->file && $galeri->tipe === 'foto') {
            Storage::disk('public')->delete($galeri->file);
        }
        $galeri->delete();
        return redirect()->route('admin.galeri.index')->with('success', 'Foto berhasil dihapus.');
    }
}
