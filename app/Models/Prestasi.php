<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $judul
 * @property string|null $deskripsi
 * @property string|null $peraih
 * @property string|null $tingkat
 * @property string|null $kategori
 * @property string|null $tahun
 * @property string|null $foto
 * @property int|null $ekstrakurikuler_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Ekstrakurikuler|null $ekstrakurikuler
 */
class Prestasi extends Model
{
    protected $table = 'prestasi';

    protected $fillable = [
        'judul', 'deskripsi', 'peraih', 'tingkat', 'kategori', 'tahun', 'foto', 'ekstrakurikuler_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Ekstrakurikuler, $this>
     */
    public function ekstrakurikuler()
    {
        return $this->belongsTo(\App\Models\Ekstrakurikuler::class);
    }
}
