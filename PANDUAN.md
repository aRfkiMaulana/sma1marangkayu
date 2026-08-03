# Website SMA Negeri 1 Marangkayu

## Stack
- **Laravel** 12 (PHP 8.2)
- **Bootstrap** 5.3 + Bootstrap Icons
- **MySQL** (via Laragon)
- **Laravel Breeze** (autentikasi)

---

## Cara Menjalankan

### 1. Konfigurasi sudah diatur di `.env`
```
DB_DATABASE=sma1marangkayu
DB_USERNAME=root
DB_PASSWORD=
```

### 2. Buka Laragon → Start All (Apache + MySQL)

### 3. Akses website
- **Website Publik:** http://sma1marangkayu.test  
  *(atau http://localhost/SMA%201%20MARANGKAYU/public)*
- **Login Admin:** http://sma1marangkayu.test/login

---

## Akun Admin Default
| Email | Password |
|-------|----------|
| admin@sman1marangkayu.sch.id | Admin@12345 |

---

## Fitur

### Halaman Publik
| Halaman | URL |
|---------|-----|
| Beranda | `/` |
| Sejarah | `/profil/sejarah` |
| Visi & Misi | `/profil/visi-misi` |
| Struktur Organisasi / Guru | `/profil/struktur-organisasi` |
| Fasilitas | `/profil/fasilitas` |
| Kurikulum | `/akademik/kurikulum` |
| Program Studi | `/akademik/program-studi` |
| Ekstrakurikuler | `/akademik/ekstrakurikuler` |
| Kalender Akademik | `/akademik/kalender` |
| Prestasi | `/akademik/prestasi` |
| Berita | `/berita` |
| Galeri | `/galeri` |
| Alumni | `/alumni` |
| Kontak | `/kontak` |

### Dashboard Admin (`/admin/dashboard`)
| Menu | Fungsi |
|------|--------|
| Slider / Banner | Kelola hero banner homepage |
| Berita & Pengumuman | CRUD berita, pengumuman, agenda |
| Galeri | Upload foto & video |
| Fasilitas | Kelola data fasilitas sekolah |
| Guru & Staf | CRUD data guru dan staf TU |
| Alumni | CRUD data alumni dengan filter tahun |
| Pesan Masuk | Lihat pesan dari form kontak |
| Profil Sekolah | Edit semua informasi sekolah |

---

## Struktur Folder Penting
```
app/
├── Http/Controllers/
│   ├── Admin/          ← Controller dashboard admin
│   └── *.php           ← Controller halaman publik
├── Models/             ← Semua model Eloquent

database/migrations/    ← Semua tabel database

resources/views/
├── admin/              ← Tampilan dashboard admin
│   ├── layouts/app.blade.php
│   ├── dashboard.blade.php
│   └── ...
├── layouts/public.blade.php  ← Layout halaman publik
└── public/             ← Semua halaman publik

routes/
├── web.php             ← Semua route
└── auth.php            ← Route login/register (Breeze)
```

---

## Reset Database (jika perlu)
```bash
php artisan migrate:fresh --seed
```
