<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ekstrakurikuler extends Model
{
    protected $table = 'ekstrakurikuler';

    protected $fillable = [
        'nama', 'deskripsi', 'pembina', 'jadwal', 'foto', 'is_aktif',
    ];

    protected $casts = [
        'is_aktif' => 'boolean',
    ];

    public function personel()
    {
        return $this->hasMany(EkskulPersonel::class)->orderBy('urutan');
    }
}
