<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AngkatanRequest;
use App\Http\Resources\AngkatanResource;
use App\Models\ActivityLog;
use App\Models\Angkatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AngkatanController extends Controller
{
    public function index(Request $request)
    {
        $angkatans = Angkatan::with(['kelas.siswas', 'siswas'])->withCount('kelas')->latest()->get();

        if ($request->wantsJson()) {
            return AngkatanResource::collection($angkatans);
        }

        return view('admin.angkatan.index', compact('angkatans'));
    }

    public function store(AngkatanRequest $request)
    {
        try {
            DB::beginTransaction();

            $angkatan = Angkatan::create($request->validated());

            ActivityLog::log('create', 'Buku Tahunan', "Menambahkan angkatan: {$angkatan->nama_angkatan}");

            DB::commit();

            if ($request->wantsJson()) {
                return (new AngkatanResource($angkatan->load(['kelas.siswas', 'siswas'])))->response()->setStatusCode(201);
            }

            return redirect()->route('admin.angkatan.index')->with('success', 'Data angkatan berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Gagal membuat angkatan: ' . $e->getMessage()], 500);
            }
            return back()->withInput()->with('error', 'Gagal membuat angkatan: ' . $e->getMessage());
        }
    }

    public function update(AngkatanRequest $request, Angkatan $angkatan)
    {
        try {
            DB::beginTransaction();

            $angkatan->update($request->validated());

            ActivityLog::log('update', 'Buku Tahunan', "Mengubah data angkatan: {$angkatan->nama_angkatan}");

            DB::commit();

            if ($request->wantsJson()) {
                return new AngkatanResource($angkatan->load(['kelas.siswas', 'siswas']));
            }

            return redirect()->route('admin.angkatan.index')->with('success', 'Data angkatan berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Gagal memperbarui angkatan: ' . $e->getMessage()], 500);
            }
            return back()->withInput()->with('error', 'Gagal memperbarui angkatan: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request, Angkatan $angkatan)
    {
        try {
            DB::beginTransaction();

            $nama = $angkatan->nama_angkatan;

            foreach ($angkatan->siswas as $siswa) {
                if ($siswa->foto) {
                    Storage::disk('public')->delete($siswa->foto);
                }
            }

            $angkatan->delete();

            ActivityLog::log('delete', 'Buku Tahunan', "Menghapus data angkatan beserta foto siswanya: {$nama}");

            DB::commit();

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Angkatan berhasil dihapus.']);
            }

            return redirect()->route('admin.angkatan.index')->with('success', 'Data angkatan berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Gagal menghapus angkatan: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Gagal menghapus angkatan: ' . $e->getMessage());
        }
    }
}
