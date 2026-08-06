<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prestasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PrestasiController extends Controller
{
    public function index()
    {
        $prestasi = Prestasi::orderBy('tahun', 'desc')->paginate(15);
        return view('admin.prestasi.index', compact('prestasi'));
    }

    public function create()
    {
        return view('admin.prestasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'peraih'    => 'nullable|string|max:255',
            'tingkat'   => 'required|in:sekolah,kecamatan,kabupaten,provinsi,nasional,internasional',
            'kategori'  => 'required|in:akademik,non_akademik,olahraga,seni',
            'tahun'     => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'foto'      => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['judul', 'deskripsi', 'peraih', 'tingkat', 'kategori', 'tahun']);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('prestasi', 'public');
        }

        Prestasi::create($data);

        return redirect()->route('admin.prestasi.index')->with('success', 'Prestasi berhasil ditambahkan.');
    }

    public function edit(Prestasi $prestasi)
    {
        return view('admin.prestasi.edit', compact('prestasi'));
    }

    public function update(Request $request, Prestasi $prestasi)
    {
        $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'peraih'    => 'nullable|string|max:255',
            'tingkat'   => 'required|in:sekolah,kecamatan,kabupaten,provinsi,nasional,internasional',
            'kategori'  => 'required|in:akademik,non_akademik,olahraga,seni',
            'tahun'     => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'foto'      => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['judul', 'deskripsi', 'peraih', 'tingkat', 'kategori', 'tahun']);

        if ($request->hasFile('foto')) {
            if ($prestasi->foto) {
                Storage::disk('public')->delete($prestasi->foto);
            }
            $data['foto'] = $request->file('foto')->store('prestasi', 'public');
        }

        $prestasi->update($data);

        return redirect()->route('admin.prestasi.index')->with('success', 'Prestasi berhasil diperbarui.');
    }

    public function destroy(Prestasi $prestasi)
    {
        if ($prestasi->foto) {
            Storage::disk('public')->delete($prestasi->foto);
        }

        $prestasi->delete();

        return redirect()->route('admin.prestasi.index')->with('success', 'Prestasi berhasil dihapus.');
    }
}
