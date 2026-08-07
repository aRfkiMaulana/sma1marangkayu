<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KelasResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $siswas = $this->siswas;
        $totalSiswa = $siswas->count();
        $filledSiswa = $siswas->whereIn('status', ['draft', 'pending', 'approved'])->count();
        $progress = $totalSiswa > 0 ? round(($filledSiswa / $totalSiswa) * 100) : 0;

        return [
            'id'              => $this->id,
            'nama_kelas'      => $this->nama_kelas,
            'angkatan'        => new AngkatanResource($this->whenLoaded('angkatan')),
            'progress_persen' => $progress,
            'statistik'       => [
                'total_siswa' => $totalSiswa,
                'approved'    => $siswas->where('status', 'approved')->count(),
                'pending'     => $siswas->where('status', 'pending')->count(),
                'draft'       => $siswas->where('status', 'draft')->count(),
                'kosong'      => $siswas->where('status', 'kosong')->count(),
                'rejected'    => $siswas->where('status', 'rejected')->count(),
            ],
        ];
    }
}
