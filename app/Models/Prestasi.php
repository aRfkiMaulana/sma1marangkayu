<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prestasi extends Model
{
    protected $table = 'prestasi';

    protected $fillable = [
        'judul', 'deskripsi', 'peraih', 'tingkat', 'kategori', 'tahun', 'foto', 'ekstrakurikuler_id',
    ];

    public function ekstrakurikuler()
    {
        return $this->belongsTo(\App\Models\Ekstrakurikuler::class);
    }
}
