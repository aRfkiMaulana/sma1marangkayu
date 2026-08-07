<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class SiswaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $kelas = $this->kelas;

        return [
            'id'              => $this->id,
            'nisn'            => $this->nisn,
            'nama'            => $this->nama,
            'kode_unik'       => $this->kode_unik,
            'kode_expired_at' => $this->kode_expired_at?->format('Y-m-d H:i:s'),
            'kode_expired'    => $this->kodeExpired(),
            'foto'            => $this->foto ? Storage::url($this->foto) : null,
            'moto'            => $this->moto,
            'status'          => $this->status,
            'kelas'           => $kelas ? [
                'id'         => $kelas->id,
                'nama_kelas' => $kelas->nama_kelas,
            ] : null,
            'angkatan'        => $kelas && $kelas->angkatan ? [
                'id'            => $kelas->angkatan->id,
                'nama_angkatan' => $kelas->angkatan->nama_angkatan,
                'tahun_lulus'   => $kelas->angkatan->tahun_lulus,
            ] : null,
        ];
    }
}
