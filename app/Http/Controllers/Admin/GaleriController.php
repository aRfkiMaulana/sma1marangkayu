<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Galeri;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $validated = $request->validate([
            'judul' => 'required|string|max:200',
            'file'  => 'required|image|max:4096',
            'album' => 'nullable|string|max:100',
        ]);

        $data = $request->except(['_token', 'file', 'link']);

        try {
            DB::beginTransaction();

            if ($request->tipe === 'foto' && $request->hasFile('file')) {
                $data['file'] = ImageService::uploadWebp($request->file('file'), 'galeri');
            } elseif ($request->tipe === 'video') {
                $data['file'] = $request->link;
            }

            $galeri = Galeri::create($data);

            ActivityLog::log('create', 'Galeri', "Menambahkan item galeri: {$galeri->judul}");

            DB::commit();
            return redirect()->route('admin.galeri.index')->with('success', 'Item galeri berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($data['file']) && $request->tipe === 'foto') {
                Storage::disk('public')->delete($data['file']);
            }
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit(Galeri $galeri)
    {
        return view('admin.galeri.edit', compact('galeri'));
    }

    public function update(Request $request, Galeri $galeri)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:200',
            'file'  => 'nullable|image|max:4096',
            'album' => 'nullable|string|max:100',
        ]);

        $data = $request->except(['_token', '_method', 'file', 'link']);
        $oldFile = $galeri->file;
        $isOldFilePhoto = ($galeri->tipe === 'foto' && $oldFile);

        try {
            DB::beginTransaction();

            if ($request->tipe === 'foto' && $request->hasFile('file')) {
                $data['file'] = ImageService::uploadWebp($request->file('file'), 'galeri');
            } elseif ($request->tipe === 'video' && $request->link) {
                $data['file'] = $request->link;
            }

            $galeri->update($data);

            if ($isOldFilePhoto && $request->hasFile('file')) {
                Storage::disk('public')->delete($oldFile);
            }

            ActivityLog::log('update', 'Galeri', "Mengubah item galeri: {$galeri->judul}");

            DB::commit();
            return redirect()->route('admin.galeri.index')->with('success', 'Item galeri berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($data['file']) && $request->tipe === 'foto' && $request->hasFile('file')) {
                Storage::disk('public')->delete($data['file']);
            }
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(Galeri $galeri)
    {
        try {
            DB::beginTransaction();

            $judul = $galeri->judul;
            $file = $galeri->file;
            $isPhoto = ($galeri->tipe === 'foto');

            $galeri->delete();

            if ($isPhoto && $file) {
                Storage::disk('public')->delete($file);
            }

            ActivityLog::log('delete', 'Galeri', "Menghapus item galeri: {$judul}");

            DB::commit();
            return redirect()->route('admin.galeri.index')->with('success', 'Item galeri berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
