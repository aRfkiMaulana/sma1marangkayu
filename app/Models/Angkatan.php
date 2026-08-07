<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Angkatan extends Model
{
    protected $table = 'angkatan';

    protected $fillable = ['nama_angkatan', 'tahun_lulus', 'dibuka_at', 'ditutup_at'];

    protected $casts = [
        'dibuka_at'  => 'datetime',
        'ditutup_at' => 'datetime',
    ];

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'angkatan_id');
    }

    public function siswas()
    {
        return $this->hasManyThrough(Siswa::class, Kelas::class, 'angkatan_id', 'kelas_id');
    }

    public function isFormAktif(): bool
    {
        $now = now();
        if ($this->dibuka_at && $now->lt($this->dibuka_at)) {
            return false;
        }
        if ($this->ditutup_at && $now->gt($this->ditutup_at)) {
            return false;
        }
        return true;
    }
}
