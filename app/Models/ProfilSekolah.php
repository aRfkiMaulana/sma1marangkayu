<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilSekolah extends Model
{
    protected $table = 'profil_sekolah';

    protected $fillable = [
        'nama_sekolah', 'npsn', 'nss', 'akreditasi', 'kepala_sekolah',
        'sejarah', 'visi', 'misi', 'tujuan',
        'alamat', 'kelurahan', 'kecamatan', 'kabupaten', 'provinsi', 'kode_pos',
        'telepon', 'whatsapp', 'email', 'website',
        'facebook', 'instagram', 'youtube',
        'logo', 'foto_sekolah', 'maps_embed',
        'jumlah_siswa', 'jumlah_guru', 'jumlah_staf', 'tahun_berdiri',
    ];

    public function getFormattedUrl(string $field): ?string
    {
        $url = $this->{$field};
        if (!$url) return null;
        return str_starts_with($url, 'http://') || str_starts_with($url, 'https://')
            ? $url
            : 'https://' . $url;
    }
}
