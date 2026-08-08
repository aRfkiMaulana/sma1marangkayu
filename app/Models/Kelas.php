<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $nama_kelas
 * @property int $angkatan_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Angkatan|null $angkatan
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Siswa> $siswas
 */
class Kelas extends Model
{
    protected $table = 'kelas';

    protected $fillable = ['nama_kelas', 'angkatan_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Angkatan, $this>
     */
    public function angkatan()
    {
        return $this->belongsTo(Angkatan::class, 'angkatan_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Siswa, $this>
     */
    public function siswas()
    {
        return $this->hasMany(Siswa::class, 'kelas_id');
    }
}
