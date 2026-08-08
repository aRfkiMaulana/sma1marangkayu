<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $nama_angkatan
 * @property string $tahun_lulus
 * @property \Illuminate\Support\Carbon|null $dibuka_at
 * @property \Illuminate\Support\Carbon|null $ditutup_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Kelas> $kelas
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Siswa> $siswas
 */
class Angkatan extends Model
{
    protected $table = 'angkatan';

    protected $fillable = ['nama_angkatan', 'tahun_lulus', 'dibuka_at', 'ditutup_at'];

    protected $casts = [
        'dibuka_at'  => 'datetime',
        'ditutup_at' => 'datetime',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Kelas, $this>
     */
    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'angkatan_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough<\App\Models\Siswa, \App\Models\Kelas, $this>
     */
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
