<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $table = 'sliders';

    protected $fillable = [
        'judul', 'subjudul', 'gambar', 'link', 'is_aktif', 'urutan',
    ];

    protected $casts = [
        'is_aktif' => 'boolean',
    ];
}
