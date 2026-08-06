<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ekstrakurikuler;
use App\Models\EkskulPersonel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EkstrakurikulerController extends Controller
{
    public function index()
    {
        $ekstrakurikuler = Ekstrakurikuler::withCount('personel')->latest()->paginate(15);
        return view('admin.ekstrakurikuler.index', compact('ekstrakurikuler'));
    }

    public function create()
    {
        return view('admin.ekstrakurikuler.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'              => 'required|string|max:150',
            'deskripsi'         => 'nullable|string',
            'pembina'           => 'nullable|string|max:150',
            'jadwal'            => 'nullable|string|max:255',
            'foto'              => 'nullable|image|max:2048',
            'personel.*.nama'   => 'required|string|max:150',
            'personel.*.jabatan'=> 'nullable|string|max:150',
        ]);

        $data = $request->only(['nama', 'deskripsi', 'pembina', 'jadwal']);
        $data['is_aktif'] = $request->boolean('is_aktif');

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('ekstrakurikuler', 'public');
        }

        $ekskul = Ekstrakurikuler::create($data);

        // Simpan personel
        foreach ($request->input('personel', []) as $i => $p) {
            if (!empty($p['nama'])) {
                $ekskul->personel()->create([
                    'nama'    => $p['nama'],
                    'jabatan' => $p['jabatan'] ?? null,
                    'urutan'  => $i,
                ]);
            }
        }

        return redirect()->route('admin.ekstrakurikuler.index')->with('success', 'Ekstrakurikuler berhasil ditambahkan.');
    }

    public function edit(Ekstrakurikuler $ekstrakurikuler)
    {
        $ekstrakurikuler->load('personel');
        return view('admin.ekstrakurikuler.edit', compact('ekstrakurikuler'));
    }

    public function update(Request $request, Ekstrakurikuler $ekstrakurikuler)
    {
        $request->validate([
            'nama'              => 'required|string|max:150',
            'deskripsi'         => 'nullable|string',
            'pembina'           => 'nullable|string|max:150',
            'jadwal'            => 'nullable|string|max:255',
            'foto'              => 'nullable|image|max:2048',
            'personel.*.nama'   => 'required|string|max:150',
            'personel.*.jabatan'=> 'nullable|string|max:150',
        ]);

        $data = $request->only(['nama', 'deskripsi', 'pembina', 'jadwal']);
        $data['is_aktif'] = $request->boolean('is_aktif');

        if ($request->hasFile('foto')) {
            if ($ekstrakurikuler->foto) {
                Storage::disk('public')->delete($ekstrakurikuler->foto);
            }
            $data['foto'] = $request->file('foto')->store('ekstrakurikuler', 'public');
        }

        $ekstrakurikuler->update($data);

        // Sync personel — hapus semua lalu insert ulang
        $ekstrakurikuler->personel()->delete();
        foreach ($request->input('personel', []) as $i => $p) {
            if (!empty($p['nama'])) {
                $ekstrakurikuler->personel()->create([
                    'nama'    => $p['nama'],
                    'jabatan' => $p['jabatan'] ?? null,
                    'urutan'  => $i,
                ]);
            }
        }

        return redirect()->route('admin.ekstrakurikuler.index')->with('success', 'Ekstrakurikuler berhasil diperbarui.');
    }

    public function destroy(Ekstrakurikuler $ekstrakurikuler)
    {
        if ($ekstrakurikuler->foto) {
            Storage::disk('public')->delete($ekstrakurikuler->foto);
        }

        $ekstrakurikuler->delete(); // personel terhapus otomatis via cascadeOnDelete

        return redirect()->route('admin.ekstrakurikuler.index')->with('success', 'Ekstrakurikuler berhasil dihapus.');
    }
}
