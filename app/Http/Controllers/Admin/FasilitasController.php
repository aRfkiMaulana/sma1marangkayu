<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FasilitasController extends Controller
{
    public function index()
    {
        $fasilitas = Fasilitas::orderBy('urutan')->paginate(15);
        return view('admin.fasilitas.index', compact('fasilitas'));
    }

    public function create()
    {
        return view('admin.fasilitas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'       => 'required|string|max:150',
            'deskripsi'  => 'nullable|string',
            'urutan'     => 'nullable|integer',
            'foto'       => 'nullable|image|max:4096',
        ]);

        $data = $request->only(['nama', 'deskripsi', 'urutan']);

        try {
            DB::beginTransaction();

            if ($request->hasFile('foto')) {
                $data['foto'] = ImageService::uploadWebp($request->file('foto'), 'fasilitas');
            }

            Fasilitas::create($data);

            DB::commit();
            return redirect()->route('admin.fasilitas.index')->with('success', 'Fasilitas berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($data['foto'])) {
                Storage::disk('public')->delete($data['foto']);
            }
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit(Fasilitas $fasilitas)
    {
        return view('admin.fasilitas.edit', compact('fasilitas'));
    }

    public function update(Request $request, Fasilitas $fasilitas)
    {
        $request->validate([
            'nama'       => 'required|string|max:150',
            'deskripsi'  => 'nullable|string',
            'urutan'     => 'nullable|integer',
            'foto'       => 'nullable|image|max:4096',
        ]);

        $data = $request->only(['nama', 'deskripsi', 'urutan']);

        try {
            DB::beginTransaction();

            if ($request->hasFile('foto')) {
                $data['foto'] = ImageService::uploadWebp($request->file('foto'), 'fasilitas');
            }

            $fasilitas->update($data);

            // Clean up old file only on successful DB update
            if ($request->hasFile('foto') && $fasilitas->getOriginal('foto')) {
                Storage::disk('public')->delete($fasilitas->getOriginal('foto'));
            }

            DB::commit();
            return redirect()->route('admin.fasilitas.index')->with('success', 'Fasilitas berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($data['foto']) && $request->hasFile('foto')) {
                Storage::disk('public')->delete($data['foto']);
            }
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(Fasilitas $fasilitas)
    {
        try {
            DB::beginTransaction();
            $foto = $fasilitas->foto;

            $fasilitas->delete();

            if ($foto) {
                Storage::disk('public')->delete($foto);
            }

            DB::commit();
            return redirect()->route('admin.fasilitas.index')->with('success', 'Fasilitas berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
