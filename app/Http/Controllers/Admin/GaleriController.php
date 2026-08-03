<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;

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
            'tipe'  => 'required|in:foto,video',
            'file'  => 'required_if:tipe,foto|nullable|image|max:4096',
            'link'  => 'required_if:tipe,video|nullable|url',
        ]);

        $data = $request->except(['_token', 'file', 'link']);

        if ($request->tipe === 'foto' && $request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('galeri', 'public');
        } elseif ($request->tipe === 'video') {
            $data['file'] = $request->link;
        }

        Galeri::create($data);
        return redirect()->route('admin.galeri.index')->with('success', 'Item galeri berhasil ditambahkan.');
    }

    public function edit(Galeri $galeri)
    {
        return view('admin.galeri.edit', compact('galeri'));
    }

    public function update(Request $request, Galeri $galeri)
    {
        $request->validate([
            'judul' => 'required|string|max:200',
            'tipe'  => 'required|in:foto,video',
            'file'  => 'nullable|image|max:4096',
            'link'  => 'nullable|url',
        ]);

        $data = $request->except(['_token', '_method', 'file', 'link']);

        if ($request->tipe === 'foto' && $request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('galeri', 'public');
        } elseif ($request->tipe === 'video' && $request->link) {
            $data['file'] = $request->link;
        }

        $galeri->update($data);
        return redirect()->route('admin.galeri.index')->with('success', 'Item galeri berhasil diperbarui.');
    }

    public function destroy(Galeri $galeri)
    {
        $galeri->delete();
        return redirect()->route('admin.galeri.index')->with('success', 'Item galeri berhasil dihapus.');
    }
}
