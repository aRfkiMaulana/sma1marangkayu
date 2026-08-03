<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ProfilSekolah;
use App\Models\KategoriBerita;
use App\Models\Slider;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat akun admin
        User::create([
            'name' => 'Admin SMAN 1 Marangkayu',
            'email' => 'admin@sman1marangkayu.sch.id',
            'password' => Hash::make('Admin@12345'),
            'email_verified_at' => now(),
        ]);

        // Profil Sekolah awal
        ProfilSekolah::create([
            'nama_sekolah'  => 'SMA Negeri 1 Marangkayu',
            'npsn'          => '30400000',
            'akreditasi'    => 'A',
            'kepala_sekolah' => 'Nama Kepala Sekolah, S.Pd., M.Pd.',
            'visi'          => 'Terwujudnya lulusan yang beriman, berilmu, berprestasi, berbudaya, dan berwawasan lingkungan.',
            'misi'          => "1. Meningkatkan keimanan dan ketaqwaan terhadap Tuhan Yang Maha Esa.\n2. Meningkatkan mutu pendidikan yang kompetitif dan relevan.\n3. Mengembangkan potensi peserta didik secara optimal.\n4. Menanamkan nilai-nilai budaya dan karakter bangsa.\n5. Menjaga dan melestarikan lingkungan hidup.",
            'alamat'        => 'Jl. Poros Samarinda - Bontang, Marangkayu',
            'kecamatan'     => 'Marangkayu',
            'kabupaten'     => 'Kutai Kartanegara',
            'provinsi'      => 'Kalimantan Timur',
            'telepon'       => '(0541) 000000',
            'email'         => 'sman1marangkayu@gmail.com',
            'jumlah_siswa'  => 600,
            'jumlah_guru'   => 45,
            'jumlah_staf'   => 15,
            'tahun_berdiri' => 1985,
            'maps_embed'    => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63865.23999998!2d117.3!3d0.1!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMMAsMCcwLjAiTiAxMTfCsDE4JzAwLjAiRQ!5e0!3m2!1sid!2sid!4v1000000000000" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
        ]);

        // Kategori Berita
        $kategori = [
            ['nama' => 'Berita Sekolah', 'slug' => 'berita-sekolah'],
            ['nama' => 'Pengumuman', 'slug' => 'pengumuman'],
            ['nama' => 'Prestasi', 'slug' => 'prestasi'],
            ['nama' => 'Kegiatan', 'slug' => 'kegiatan'],
        ];
        foreach ($kategori as $k) {
            KategoriBerita::create($k);
        }

        // Slider awal
        Slider::create([
            'judul'    => 'Selamat Datang di SMA Negeri 1 Marangkayu',
            'subjudul' => 'Unggul dalam Prestasi, Mulia dalam Akhlak',
            'gambar'   => 'sliders/default-slider-1.jpg',
            'is_aktif' => true,
            'urutan'   => 1,
        ]);
    }
}
