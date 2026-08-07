<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Services\SiswaService;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswasImport implements ToCollection, WithHeadingRow
{
    protected int $kelasId;
    protected int $tahunLulus;
    protected ?Carbon $dibukaAt;
    protected int $successCount = 0;
    protected array $failures = [];

    public function __construct(int $kelasId, int $tahunLulus, ?Carbon $dibukaAt)
    {
        $this->kelasId = $kelasId;
        $this->tahunLulus = $tahunLulus;
        $this->dibukaAt = $dibukaAt;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            $rowNum = $index + 2; // header line offset
            $nisn = trim((string) ($row['nisn'] ?? ''));
            $nama = trim((string) ($row['nama'] ?? ''));

            if (!preg_match('/^\d{10}$/', $nisn)) {
                $this->failures[] = "Baris #{$rowNum}: NISN ('{$nisn}') harus 10 digit angka.";
                continue;
            }

            if (empty($nama)) {
                $this->failures[] = "Baris #{$rowNum}: Nama siswa tidak boleh kosong.";
                continue;
            }

            if (Siswa::where('nisn', $nisn)->exists()) {
                $this->failures[] = "Baris #{$rowNum}: NISN ('{$nisn}') sudah terdaftar di sistem.";
                continue;
            }

            $kodeExpiredAt = $this->dibukaAt ? (clone $this->dibukaAt)->addDays(7) : now()->addDays(7);

            Siswa::create([
                'kelas_id'        => $this->kelasId,
                'nisn'            => $nisn,
                'nama'            => $nama,
                'kode_unik'       => SiswaService::generateKodeUnik($this->tahunLulus),
                'kode_expired_at' => $kodeExpiredAt,
                'status'          => 'kosong',
            ]);

            $this->successCount++;
        }
    }

    public function getSuccessCount(): int
    {
        return $this->successCount;
    }

    public function getFailures(): array
    {
        return $this->failures;
    }
}
