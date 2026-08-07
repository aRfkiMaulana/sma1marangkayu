<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswas';

    protected $fillable = [
        'nisn',
        'nama',
        'kode_unik',
        'kode_expired_at',
        'foto',
        'moto',
        'status',
        'kelas_id',
    ];

    protected $casts = [
        'kode_expired_at' => 'datetime',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function angkatan()
    {
        return $this->hasOneThrough(Angkatan::class, Kelas::class, 'id', 'id', 'kelas_id', 'angkatan_id');
    }

    public function sudahSubmit(): bool
    {
        return $this->status !== 'kosong';
    }

    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function kodeExpired(): bool
    {
        return $this->kode_expired_at && now()->gt($this->kode_expired_at);
    }

    public function bisaSubmit(): bool
    {
        return in_array($this->status, ['kosong', 'draft']) && !$this->kodeExpired();
    }
}
