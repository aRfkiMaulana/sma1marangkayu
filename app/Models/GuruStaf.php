<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuruStaf extends Model
{
    protected $table = 'guru_staf';

    protected $fillable = [
        'nama', 'nip', 'jabatan', 'mata_pelajaran',
        'pendidikan_terakhir', 'foto', 'tipe', 'email', 'is_aktif', 'urutan',
    ];

    protected $casts = [
        'is_aktif' => 'boolean',
    ];

    public function scopeGuru($query)
    {
        return $query->where('tipe', 'guru');
    }

    public function scopeStaf($query)
    {
        return $query->where('tipe', 'staf');
    }
}
