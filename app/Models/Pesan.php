<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesan extends Model
{
    protected $table = 'pesan';

    protected $fillable = [
        'nama', 'email', 'telepon', 'subjek', 'pesan', 'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];
}
