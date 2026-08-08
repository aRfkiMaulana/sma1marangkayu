<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $nama
 * @property string|null $deskripsi
 * @property string|null $pembina
 * @property string|null $jadwal
 * @property string|null $foto
 * @property int|null $skor_prestasi
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EkskulPersonel> $personel
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Prestasi> $prestasi
 */
class Ekstrakurikuler extends Model
{
    protected $table = 'ekstrakurikuler';

    protected $fillable = [
        'nama', 'deskripsi', 'pembina', 'jadwal', 'foto', 'is_aktif',
    ];

    protected $casts = [
        'is_aktif' => 'boolean',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\EkskulPersonel, $this>
     */
    public function personel()
    {
        return $this->hasMany(EkskulPersonel::class)->orderBy('urutan');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Prestasi, $this>
     */
    public function prestasi()
    {
        return $this->hasMany(\App\Models\Prestasi::class)->orderByDesc('tahun');
    }
}
