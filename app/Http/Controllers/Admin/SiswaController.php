<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ImportSiswaRequest;

use App\Http\Resources\SiswaResource;
use App\Models\ActivityLog;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Services\SiswaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    protected SiswaService $siswaService;

    public function __construct(SiswaService $siswaService)
    {
        $this->siswaService = $siswaService;
    }

    public function index(Request $request)
    {
        $query = Siswa::with(['kelas.angkatan']);

        if ($request->filled('angkatan_id')) {
            $query->whereHas('kelas', function ($q) use ($request) {
                $q->where('angkatan_id', $request->angkatan_id);
            });
        }

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('nisn', 'like', '%' . $request->search . '%');
            });
        }

        $siswas = $query->latest()->paginate(20);

        if ($request->wantsJson()) {
            return SiswaResource::collection($siswas);
        }

        $kelasList = $request->filled('angkatan_id')
            ? Kelas::with('angkatan')->where('angkatan_id', $request->angkatan_id)->get()
            : Kelas::with('angkatan')->get();

        $angkatans = \App\Models\Angkatan::orderBy('tahun_lulus', 'desc')->get();

        return view('admin.siswa.index', compact('siswas', 'kelasList', 'angkatans'));
    }

    public function importExcel(ImportSiswaRequest $request)
    {
        $res = $this->siswaService->importSiswa($request->file('file'), $request->kelas_id);

        ActivityLog::log('create', 'Buku Tahunan', "Import Excel siswa untuk kelas_id: {$request->kelas_id}. Berhasil: {$res['berhasil']}, Gagal: {$res['gagal']}");

        if ($request->wantsJson()) {
            return response()->json($res);
        }

        if ($res['gagal'] > 0 && $res['berhasil'] === 0) {
            return back()->with('error', 'Gagal import Excel: ' . implode(' ', $res['errors']));
        }

        return redirect()->route('admin.siswa.index', ['kelas_id' => $request->kelas_id])
            ->with('success', "Import berhasil: {$res['berhasil']} siswa ditambahkan." . ($res['gagal'] > 0 ? " ({$res['gagal']} gagal)" : ''));
    }

    public function exportKode(Request $request)
    {
        $request->validate(['kelas_id' => 'required|exists:kelas,id']);

        $data = $this->siswaService->exportKodePrint($request->kelas_id);

        if ($request->wantsJson()) {
            return response()->json($data);
        }

        return view('admin.siswa.export-kode', compact('data'));
    }

    public function approve(Request $request, Siswa $siswa)
    {
        try {
            DB::beginTransaction();

            $siswa->update(['status' => 'approved']);
            ActivityLog::log('update', 'Buku Tahunan', "Approve foto & moto siswa: {$siswa->nama}");

            DB::commit();

            if ($request->wantsJson()) {
                return new SiswaResource($siswa->load(['kelas.angkatan']));
            }

            return back()->with('success', "Data {$siswa->nama} disetujui.");
        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Gagal approve: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Gagal approve: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, Siswa $siswa)
    {
        try {
            DB::beginTransaction();

            $this->siswaService->resetSiswa($siswa->id);
            ActivityLog::log('update', 'Buku Tahunan', "Reject foto & moto siswa: {$siswa->nama} (reset ke draft)");

            DB::commit();

            if ($request->wantsJson()) {
                return new SiswaResource($siswa->fresh()->load(['kelas.angkatan']));
            }

            return back()->with('success', "Data {$siswa->nama} ditolak dan di-reset ke status draft.");
        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Gagal reject: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Gagal reject: ' . $e->getMessage());
        }
    }

    public function bulkApprove(Request $request)
    {
        $request->validate(['kelas_id' => 'required|exists:kelas,id']);

        try {
            DB::beginTransaction();

            $count = Siswa::where('kelas_id', $request->kelas_id)
                ->where('status', 'pending')
                ->update(['status' => 'approved']);

            ActivityLog::log('update', 'Buku Tahunan', "Bulk approve {$count} siswa pending di kelas_id: {$request->kelas_id}");

            DB::commit();

            if ($request->wantsJson()) {
                return response()->json(['message' => "Berhasil menyetujui {$count} siswa pending."]);
            }

            return back()->with('success', "Berhasil menyetujui {$count} siswa pending.");
        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Gagal bulk approve: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Gagal bulk approve: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request, Siswa $siswa)
    {
        try {
            DB::beginTransaction();

            $nama = $siswa->nama;
            if ($siswa->foto) {
                Storage::disk('public')->delete($siswa->foto);
            }

            $siswa->delete();

            ActivityLog::log('delete', 'Buku Tahunan', "Menghapus siswa: {$nama}");

            DB::commit();

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Data siswa berhasil dihapus.']);
            }

            return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Gagal menghapus siswa: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Gagal menghapus siswa: ' . $e->getMessage());
        }
    }
}
