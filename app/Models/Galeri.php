<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    protected $table = 'galeri';

    protected $fillable = [
        'judul', 'deskripsi', 'file', 'tipe', 'album', 'is_highlight', 'urutan',
    ];

    protected $casts = [
        'is_highlight' => 'boolean',
    ];
}
