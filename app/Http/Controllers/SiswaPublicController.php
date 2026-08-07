<?php

namespace App\Http\Controllers;

use App\Http\Requests\KirimKeAdminRequest;
use App\Http\Requests\SubmitSiswaRequest;
use App\Http\Requests\VerifikasiRequest;
use App\Http\Resources\SiswaResource;
use App\Models\Angkatan;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Services\HtmlSanitizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use Intervention\Image\Laravel\Facades\Image;

class SiswaPublicController extends Controller
{
    public function bukuTahunan(Request $request)
    {
        $query = Siswa::with(['kelas.angkatan'])->where('status', 'approved');

        if ($request->filled('angkatan_id')) {
            $query->whereHas('kelas', function ($q) use ($request) {
                $q->where('angkatan_id', $request->angkatan_id);
            });
        }

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        $siswas = $query->latest()->paginate(16);

        if ($request->wantsJson()) {
            return SiswaResource::collection($siswas);
        }

        $angkatans = Angkatan::orderBy('tahun_lulus', 'desc')->get();
        $kelasList = $request->filled('angkatan_id')
            ? Kelas::where('angkatan_id', $request->angkatan_id)->get()
            : Kelas::all();

        return view('public.buku-tahunan.index', compact('siswas', 'angkatans', 'kelasList'));
    }

    public function verifikasi(VerifikasiRequest $request)
    {
        $siswa = Siswa::with(['kelas.angkatan'])->where('nisn', $request->nisn)->first();

        if (!$siswa || strtoupper($siswa->kode_unik) !== strtoupper($request->kode_unik)) {
            return response()->json(['message' => 'Data tidak ditemukan.'], 404);
        }

        if ($siswa->kodeExpired()) {
            return response()->json(['message' => 'Kode sudah expired, hubungi admin.'], 422);
        }

        if (in_array($siswa->status, ['pending', 'approved'])) {
            return response()->json(['message' => 'Kamu sudah mengirim data ke admin.'], 422);
        }

        if ($siswa->status === 'rejected') {
            return response()->json(['message' => 'Datamu ditolak admin, hubungi wali kelas.'], 422);
        }

        return response()->json([
            'nama'     => $siswa->nama,
            'kelas'    => $siswa->kelas->nama_kelas,
            'angkatan' => $siswa->kelas->angkatan->nama_angkatan,
            'status'   => $siswa->status,
            'ada_foto' => !empty($siswa->foto),
            'moto'     => $siswa->moto,
        ]);
    }

    public function simpanDraft(SubmitSiswaRequest $request)
    {
        $siswa = Siswa::with(['kelas.angkatan'])->where('nisn', $request->nisn)->firstOrFail();

        if (strtoupper($siswa->kode_unik) !== strtoupper($request->kode_unik)) {
            return response()->json(['message' => 'Kode Unik tidak valid.'], 403);
        }

        if ($siswa->kodeExpired()) {
            return response()->json(['message' => 'Kode sudah expired, hubungi admin.'], 422);
        }

        if (!in_array($siswa->status, ['kosong', 'draft'])) {
            return response()->json(['message' => 'Data tidak dapat diubah karena status saat ini: ' . $siswa->status], 422);
        }

        $angkatan = $siswa->kelas->angkatan;
        if (!$angkatan->isFormAktif()) {
            return response()->json(['message' => 'Form pengisian buku tahunan sedang ditutup.'], 403);
        }

        try {
            DB::beginTransaction();

            $data = ['moto' => HtmlSanitizer::clean($request->moto)];

            if ($request->hasFile('foto')) {
                $oldFoto = $siswa->foto;

                $tahunLulus = $angkatan->tahun_lulus;
                $namaKelas  = \Illuminate\Support\Str::slug($siswa->kelas->nama_kelas);
                $folderPath = "buku-tahunan/{$tahunLulus}/{$namaKelas}";

                $file = $request->file('foto');
                $filename = "{$siswa->nisn}_" . time() . ".webp";
                $fullPath = "{$folderPath}/{$filename}";

                $img = Image::read($file->getRealPath())->cover(300, 400)->encodeByExtension('webp', quality: 85);
                Storage::disk('public')->put($fullPath, (string) $img);

                $data['foto'] = $fullPath;

                if ($oldFoto) {
                    Storage::disk('public')->delete($oldFoto);
                }
            }

            $data['status'] = 'draft';
            $siswa->update($data);

            DB::commit();

            return new SiswaResource($siswa->fresh()->load(['kelas.angkatan']));
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Gagal menyimpan draft: ' . $e->getMessage()], 500);
        }
    }

    public function kirimKeAdmin(KirimKeAdminRequest $request)
    {
        $siswa = Siswa::where('nisn', $request->nisn)->firstOrFail();

        if (strtoupper($siswa->kode_unik) !== strtoupper($request->kode_unik)) {
            return response()->json(['message' => 'Kode Unik tidak valid.'], 403);
        }

        if (!$siswa->isDraft()) {
            return response()->json(['message' => 'Status harus draft sebelum bisa dikirim ke admin.'], 422);
        }

        if (!$siswa->foto || !$siswa->moto) {
            return response()->json(['message' => 'Foto dan Moto wajib diisi sebelum dikirim ke admin.'], 422);
        }

        $siswa->update(['status' => 'pending']);

        return new SiswaResource($siswa->load(['kelas.angkatan']));
    }

    public function cekStatus(Request $request)
    {
        $request->validate([
            'nisn'      => 'required|string',
            'kode_unik' => 'required|string',
        ]);

        $siswa = Siswa::where('nisn', $request->nisn)->first();

        if (!$siswa || strtoupper($siswa->kode_unik) !== strtoupper($request->kode_unik)) {
            return response()->json(['message' => 'Data tidak ditemukan.'], 404);
        }

        $messages = [
            'kosong'   => 'Belum mengisi data',
            'draft'    => 'Data tersimpan, belum dikirim ke admin',
            'pending'  => 'Menunggu review admin',
            'approved' => 'Data disetujui, tampil di buku tahunan',
            'rejected' => 'Data ditolak admin, silakan submit ulang',
        ];

        return response()->json([
            'status'  => $siswa->status,
            'pesan'   => $messages[$siswa->status] ?? $siswa->status,
            'siswa'   => new SiswaResource($siswa->load(['kelas.angkatan'])),
        ]);
    }
}
