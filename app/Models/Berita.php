<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $table = 'berita';

    protected $fillable = [
        'kategori_id', 'user_id', 'judul', 'slug', 'ringkasan',
        'konten', 'thumbnail', 'tipe', 'status', 'tanggal_publish', 'views',
    ];

    protected $casts = [
        'tanggal_publish' => 'datetime',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriBerita::class, 'kategori_id');
    }

    public function penulis()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
