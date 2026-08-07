<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\KelasRequest;
use App\Http\Resources\KelasResource;
use App\Models\ActivityLog;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        $query = Kelas::with(['angkatan', 'siswas']);

        if ($request->filled('angkatan_id')) {
            $query->where('angkatan_id', $request->angkatan_id);
        }

        $kelasList = $query->latest()->get();
        $angkatans = \App\Models\Angkatan::orderBy('tahun_lulus', 'desc')->get();

        if ($request->wantsJson()) {
            return KelasResource::collection($kelasList);
        }

        return view('admin.kelas.index', compact('kelasList', 'angkatans'));
    }

    public function store(KelasRequest $request)
    {
        try {
            DB::beginTransaction();

            $kelas = Kelas::create($request->validated());

            ActivityLog::log('create', 'Buku Tahunan', "Menambahkan kelas: {$kelas->nama_kelas}");

            DB::commit();

            if ($request->wantsJson()) {
                return (new KelasResource($kelas->load(['angkatan', 'siswas'])))->response()->setStatusCode(201);
            }

            return redirect()->route('admin.kelas.index', ['angkatan_id' => $kelas->angkatan_id])
                ->with('success', 'Data kelas berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Gagal menambah kelas: ' . $e->getMessage()], 500);
            }
            return back()->withInput()->with('error', 'Gagal menambah kelas: ' . $e->getMessage());
        }
    }

    public function update(KelasRequest $request, Kelas $kela)
    {
        try {
            DB::beginTransaction();

            $kela->update($request->validated());

            ActivityLog::log('update', 'Buku Tahunan', "Mengubah data kelas: {$kela->nama_kelas}");

            DB::commit();

            if ($request->wantsJson()) {
                return new KelasResource($kela->load(['angkatan', 'siswas']));
            }

            return redirect()->route('admin.kelas.index', ['angkatan_id' => $kela->angkatan_id])
                ->with('success', 'Data kelas berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Gagal memperbarui kelas: ' . $e->getMessage()], 500);
            }
            return back()->withInput()->with('error', 'Gagal memperbarui kelas: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request, Kelas $kela)
    {
        try {
            DB::beginTransaction();

            $nama = $kela->nama_kelas;
            $angkatanId = $kela->angkatan_id;

            foreach ($kela->siswas as $siswa) {
                if ($siswa->foto) {
                    Storage::disk('public')->delete($siswa->foto);
                }
            }

            $kela->delete();

            ActivityLog::log('delete', 'Buku Tahunan', "Menghapus kelas beserta foto siswanya: {$nama}");

            DB::commit();

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Kelas berhasil dihapus.']);
            }

            return redirect()->route('admin.kelas.index', ['angkatan_id' => $angkatanId])
                ->with('success', 'Data kelas berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Gagal menghapus kelas: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Gagal menghapus kelas: ' . $e->getMessage());
        }
    }
}
