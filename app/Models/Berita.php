<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int|null $kategori_id
 * @property int|null $user_id
 * @property string $judul
 * @property string $slug
 * @property string|null $ringkasan
 * @property string $konten
 * @property string|null $thumbnail
 * @property string $tipe
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $tanggal_publish
 * @property int $views
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\KategoriBerita|null $kategori
 * @property-read \App\Models\User|null $penulis
 */
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\KategoriBerita, $this>
     */
    public function kategori()
    {
        return $this->belongsTo(KategoriBerita::class, 'kategori_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\User, $this>
     */
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
