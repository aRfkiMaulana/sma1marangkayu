<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AngkatanResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $siswas = $this->siswas;

        return [
            'id'            => $this->id,
            'nama_angkatan' => $this->nama_angkatan,
            'tahun_lulus'   => (int) $this->tahun_lulus,
            'dibuka_at'     => $this->dibuka_at?->format('Y-m-d H:i:s'),
            'ditutup_at'    => $this->ditutup_at?->format('Y-m-d H:i:s'),
            'form_aktif'    => $this->isFormAktif(),
            'total_kelas'   => $this->whenCounted('kelas', $this->kelas_count ?? $this->kelas()->count()),
            'statistik'     => [
                'total_siswa' => $siswas->count(),
                'approved'    => $siswas->where('status', 'approved')->count(),
                'pending'     => $siswas->where('status', 'pending')->count(),
                'draft'       => $siswas->where('status', 'draft')->count(),
                'kosong'      => $siswas->where('status', 'kosong')->count(),
                'rejected'    => $siswas->where('status', 'rejected')->count(),
            ],
        ];
    }
}
