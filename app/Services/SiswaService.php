<?php

namespace App\Services;

use App\Imports\SiswasImport;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class SiswaService
{
    public static function generateKodeUnik(int $tahun = 0): string
    {
        do {
            $kode = strtoupper(Str::random(6));
        } while (Siswa::where('kode_unik', $kode)->exists());

        return $kode;
    }

    public function importSiswa(UploadedFile $file, int $kelasId): array
    {
        $kelas = Kelas::with('angkatan')->findOrFail($kelasId);
        $angkatan = $kelas->angkatan;

        $import = new SiswasImport($kelasId, $angkatan->tahun_lulus, $angkatan->dibuka_at);

        try {
            DB::beginTransaction();
            Excel::import($import, $file);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'berhasil' => 0,
                'gagal'    => 1,
                'errors'   => ['File Excel tidak dapat diproses: ' . $e->getMessage()],
            ];
        }

        return [
            'berhasil' => $import->getSuccessCount(),
            'gagal'    => count($import->getFailures()),
            'errors'   => $import->getFailures(),
        ];
    }

    public function exportKodePrint(int $kelasId): array
    {
        $kelas = Kelas::with(['angkatan', 'siswas'])->findOrFail($kelasId);

        return [
            'nama_sekolah'  => 'SMA Negeri 1 Marangkayu',
            'nama_kelas'    => $kelas->nama_kelas,
            'nama_angkatan' => $kelas->angkatan->nama_angkatan,
            'tahun_lulus'   => $kelas->angkatan->tahun_lulus,
            'siswa'         => $kelas->siswas->map(function ($s, $i) {
                return [
                    'no'              => $i + 1,
                    'nama'            => $s->nama,
                    'nisn'            => $s->nisn,
                    'kode_unik'       => $s->kode_unik,
                    'kode_expired_at' => $s->kode_expired_at?->format('Y-m-d H:i:s'),
                ];
            })->toArray(),
        ];
    }

    public function resetSiswa(int $siswaId): bool
    {
        $siswa = Siswa::findOrFail($siswaId);

        if ($siswa->foto) {
            Storage::disk('public')->delete($siswa->foto);
        }

        return $siswa->update([
            'status' => 'draft',
            'foto'   => null,
            'moto'   => null,
        ]);
    }
}
