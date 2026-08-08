<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Akademik extends Model
{
    protected $table = 'akademik';

    protected $fillable = [
        'judul', 'konten', 'tipe', 'file_lampiran', 'is_aktif', 'urutan', 'meta_data',
    ];

    protected $casts = [
        'is_aktif' => 'boolean',
        'meta_data' => 'array',
    ];
}
