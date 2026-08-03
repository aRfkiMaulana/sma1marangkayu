<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\AkademikController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfilSekolahController;
use App\Http\Controllers\Admin\BeritaController as AdminBeritaController;
use App\Http\Controllers\Admin\GaleriController as AdminGaleriController;
use App\Http\Controllers\Admin\GuruStafController;
use App\Http\Controllers\Admin\PesanController;
use App\Http\Controllers\Admin\FasilitasController;
use App\Http\Controllers\Admin\SliderController;

// ─── PUBLIC ROUTES ───────────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');

// Profil
Route::prefix('profil')->name('profil.')->group(function () {
    Route::get('/sejarah', [ProfilController::class, 'sejarah'])->name('sejarah');
    Route::get('/visi-misi', [ProfilController::class, 'visiMisi'])->name('visi-misi');
    Route::get('/struktur-organisasi', [ProfilController::class, 'strukturOrganisasi'])->name('struktur-organisasi');
    Route::get('/fasilitas', [ProfilController::class, 'fasilitas'])->name('fasilitas');
});

// Akademik
Route::prefix('akademik')->name('akademik.')->group(function () {
    Route::get('/kurikulum', [AkademikController::class, 'kurikulum'])->name('kurikulum');
    Route::get('/program-studi', [AkademikController::class, 'programStudi'])->name('program-studi');
    Route::get('/ekstrakurikuler', [AkademikController::class, 'ekstrakurikuler'])->name('ekstrakurikuler');
    Route::get('/kalender', [AkademikController::class, 'kalender'])->name('kalender');
    Route::get('/prestasi', [AkademikController::class, 'prestasi'])->name('prestasi');
});

// Berita
Route::prefix('berita')->name('berita.')->group(function () {
    Route::get('/', [BeritaController::class, 'index'])->name('index');
    Route::get('/kategori/{kategori:slug}', [BeritaController::class, 'kategori'])->name('kategori');
    Route::get('/{berita:slug}', [BeritaController::class, 'show'])->name('show');
});

// Galeri
Route::prefix('galeri')->name('galeri.')->group(function () {
    Route::get('/', [GaleriController::class, 'index'])->name('index');
    Route::get('/album/{album}', [GaleriController::class, 'album'])->name('album');
});

// Kontak
Route::get('/kontak', [KontakController::class, 'index'])->name('kontak');
Route::post('/kontak/kirim', [KontakController::class, 'kirim'])->name('kontak.kirim');

// ─── AUTH ROUTES ─────────────────────────────────────────────────────────────
require __DIR__ . '/auth.php';

// ─── ADMIN ROUTES ────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profil Sekolah
    Route::get('/profil', [ProfilSekolahController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [ProfilSekolahController::class, 'update'])->name('profil.update');

    // Berita
    Route::resource('berita', AdminBeritaController::class)->except(['show']);

    // Galeri
    Route::resource('galeri', AdminGaleriController::class)->except(['show']);

    // Guru & Staf
    Route::resource('guru-staf', GuruStafController::class)->except(['show']);

    // Fasilitas
    Route::resource('fasilitas', FasilitasController::class)->except(['show']);

    // Slider
    Route::resource('slider', SliderController::class)->except(['show']);

    // Pesan
    Route::get('/pesan', [PesanController::class, 'index'])->name('pesan.index');
    Route::get('/pesan/{pesan}', [PesanController::class, 'show'])->name('pesan.show');
    Route::delete('/pesan/{pesan}', [PesanController::class, 'destroy'])->name('pesan.destroy');
});
