<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EkskulPersonel extends Model
{
    protected $table = 'ekskul_personel';

    protected $fillable = ['ekstrakurikuler_id', 'nama', 'jabatan', 'urutan'];

    public function ekstrakurikuler()
    {
        return $this->belongsTo(Ekstrakurikuler::class);
    }
}
