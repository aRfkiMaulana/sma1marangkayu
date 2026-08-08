<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KalenderAkademik extends Model
{
    protected $fillable = [
        'judul',
        'tanggal_mulai',
        'tanggal_selesai',
        'kategori',
        'gambar',
        'keterangan',
        'tahun_ajaran',
        'is_aktif',
    ];

    protected $casts = [
        'tanggal_mulai'   => 'date',
        'tanggal_selesai' => 'date',
        'is_aktif'        => 'boolean',
    ];
}
