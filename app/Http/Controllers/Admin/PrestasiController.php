<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Prestasi;
use App\Models\Ekstrakurikuler;
use App\Services\HtmlSanitizer;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PrestasiController extends Controller
{
    public function index()
    {
        $prestasi = Prestasi::with('ekstrakurikuler')->orderBy('tahun', 'desc')->paginate(15);
        return view('admin.prestasi.index', compact('prestasi'));
    }

    public function create()
    {
        $ekskul = Ekstrakurikuler::orderBy('nama')->get();
        return view('admin.prestasi.create', compact('ekskul'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'               => 'required|string|max:255',
            'deskripsi'           => 'nullable|string',
            'peraih'              => 'nullable|string|max:255',
            'tingkat'             => 'required|in:sekolah,kecamatan,kabupaten,provinsi,nasional,internasional',
            'kategori'            => 'required|in:akademik,non_akademik,olahraga,seni',
            'tahun'               => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'foto'                => 'nullable|image|max:4096',
            'ekstrakurikuler_id'  => 'nullable|exists:ekstrakurikuler,id',
        ]);

        $data = $request->only(['judul', 'deskripsi', 'peraih', 'tingkat', 'kategori', 'tahun', 'ekstrakurikuler_id']);
        $data['deskripsi'] = HtmlSanitizer::clean($data['deskripsi'] ?? null);

        try {
            DB::beginTransaction();

            if ($request->hasFile('foto')) {
                $data['foto'] = ImageService::uploadWebp($request->file('foto'), 'prestasi');
            }

            $prestasi = Prestasi::create($data);

            ActivityLog::log('create', 'Prestasi', "Menambahkan prestasi: {$prestasi->judul}");

            DB::commit();
            return redirect()->route('admin.prestasi.index')->with('success', 'Prestasi berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($data['foto'])) {
                Storage::disk('public')->delete($data['foto']);
            }
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit(Prestasi $prestasi)
    {
        $ekskul = Ekstrakurikuler::orderBy('nama')->get();
        return view('admin.prestasi.edit', compact('prestasi', 'ekskul'));
    }

    public function update(Request $request, Prestasi $prestasi)
    {
        $request->validate([
            'judul'               => 'required|string|max:255',
            'deskripsi'           => 'nullable|string',
            'peraih'              => 'nullable|string|max:255',
            'tingkat'             => 'required|in:sekolah,kecamatan,kabupaten,provinsi,nasional,internasional',
            'kategori'            => 'required|in:akademik,non_akademik,olahraga,seni',
            'tahun'               => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'foto'                => 'nullable|image|max:4096',
            'ekstrakurikuler_id'  => 'nullable|exists:ekstrakurikuler,id',
        ]);

        $data = $request->only(['judul', 'deskripsi', 'peraih', 'tingkat', 'kategori', 'tahun', 'ekstrakurikuler_id']);
        $data['deskripsi'] = HtmlSanitizer::clean($data['deskripsi'] ?? null);
        $oldFoto = $prestasi->foto;

        try {
            DB::beginTransaction();

            if ($request->hasFile('foto')) {
                $data['foto'] = ImageService::uploadWebp($request->file('foto'), 'prestasi');
            }

            $prestasi->update($data);

            if ($oldFoto && $request->hasFile('foto')) {
                Storage::disk('public')->delete($oldFoto);
            }

            ActivityLog::log('update', 'Prestasi', "Mengubah prestasi: {$prestasi->judul}");

            DB::commit();
            return redirect()->route('admin.prestasi.index')->with('success', 'Prestasi berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($data['foto']) && $request->hasFile('foto')) {
                Storage::disk('public')->delete($data['foto']);
            }
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(Prestasi $prestasi)
    {
        try {
            DB::beginTransaction();

            $judul = $prestasi->judul;
            $foto = $prestasi->foto;

            $prestasi->delete();

            if ($foto) {
                Storage::disk('public')->delete($foto);
            }

            ActivityLog::log('delete', 'Prestasi', "Menghapus prestasi: {$judul}");

            DB::commit();
            return redirect()->route('admin.prestasi.index')->with('success', 'Prestasi berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
