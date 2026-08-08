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
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\BeritaController as AdminBeritaController;
use App\Http\Controllers\Admin\GaleriController as AdminGaleriController;
use App\Http\Controllers\Admin\GuruStafController;
use App\Http\Controllers\Admin\PesanController;
use App\Http\Controllers\Admin\FasilitasController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\EkstrakurikulerController;
use App\Http\Controllers\Admin\PrestasiController;
use App\Http\Controllers\Admin\SettingBobotController;
use App\Http\Controllers\Admin\AngkatanController as AdminAngkatanController;
use App\Http\Controllers\Admin\KelasController as AdminKelasController;
use App\Http\Controllers\Admin\SiswaController as AdminSiswaController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\SiswaPublicController;

// ─── PUBLIC ROUTES ───────────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');

// Profil
Route::prefix('profil')->name('profil.')->group(function () {
    Route::get('/profil-sekolah', [ProfilController::class, 'profilSekolah'])->name('profil-sekolah');
    Route::get('/sejarah', [ProfilController::class, 'sejarah'])->name('sejarah');
    Route::get('/visi-misi', [ProfilController::class, 'visiMisi'])->name('visi-misi');
    Route::get('/struktur-organisasi', [ProfilController::class, 'strukturOrganisasi'])->name('struktur-organisasi');
    Route::get('/fasilitas', [ProfilController::class, 'fasilitas'])->name('fasilitas');
});

// Akademik
Route::prefix('akademik')->name('akademik.')->group(function () {
    Route::get('/kurikulum', [AkademikController::class, 'kurikulum'])->name('kurikulum');
    Route::get('/ekstrakurikuler', [AkademikController::class, 'ekstrakurikuler'])->name('ekstrakurikuler');
    Route::get('/ekstrakurikuler/{ekstrakurikuler}', [AkademikController::class, 'ekstrakurikulerShow'])->name('ekstrakurikuler.show');
    Route::get('/kalender', [AkademikController::class, 'kalender'])->name('kalender');
    Route::get('/prestasi', [AkademikController::class, 'prestasi'])->name('prestasi');
    Route::get('/prestasi/{prestasi}', [AkademikController::class, 'prestasiShow'])->name('prestasi.show');
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
Route::post('/kontak/kirim', [KontakController::class, 'kirim'])->middleware('throttle:5,1')->name('kontak.kirim');

// Buku Tahunan Publik (Tanpa Auth)
Route::get('/buku-tahunan', [SiswaPublicController::class, 'bukuTahunan'])->name('buku-tahunan.index');
Route::post('/buku-tahunan/verifikasi', [SiswaPublicController::class, 'verifikasi'])->name('buku-tahunan.verifikasi');
Route::post('/buku-tahunan/simpan-draft', [SiswaPublicController::class, 'simpanDraft'])->name('buku-tahunan.simpan-draft');
Route::post('/buku-tahunan/kirim-ke-admin', [SiswaPublicController::class, 'kirimKeAdmin'])->name('buku-tahunan.kirim-ke-admin');
Route::get('/buku-tahunan/cek-status', [SiswaPublicController::class, 'cekStatus'])->name('buku-tahunan.cek-status');

// Chatbot API
Route::post('/chatbot/send', [\App\Http\Controllers\ChatbotController::class, 'chat'])->middleware('throttle:30,1')->name('chatbot.send');

// ─── AUTH ROUTES ─────────────────────────────────────────────────────────────
require __DIR__ . '/auth.php';

// ─── DASHBOARD REDIRECT ALIAS ───────────────────────────────────────────────
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'admin'])->name('dashboard');
// ─── ADMIN / PANEL ROUTES (CUSTOM SECURE PATH) ───────────────────────────────
Route::prefix('panel-smansa')->name('admin.')->middleware(['auth', 'admin'])->group(function () {

    Route::get('/overview', [DashboardController::class, 'index'])->name('dashboard');

    // Profil Sekolah
    Route::get('/profil', [ProfilSekolahController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [ProfilSekolahController::class, 'update'])->name('profil.update');

    // Berita
    Route::resource('berita', AdminBeritaController::class)->except(['show'])->parameters(['berita' => 'berita']);

    // Galeri
    Route::resource('galeri', AdminGaleriController::class)->except(['show']);

    // Guru & Staf
    Route::resource('guru-staf', GuruStafController::class)->except(['show']);

    // Fasilitas
    Route::resource('fasilitas', FasilitasController::class)->except(['show'])->parameters(['fasilitas' => 'fasilitas']);

    // Slider
    Route::resource('slider', SliderController::class)->except(['show']);

    // Ekstrakurikuler
    Route::resource('ekstrakurikuler', EkstrakurikulerController::class)->except(['show']);

    // Prestasi
    Route::resource('prestasi', PrestasiController::class)->except(['show']);

    // Kalender Akademik
    Route::get('/kalender', [\App\Http\Controllers\Admin\KalenderAkademikController::class, 'index'])->name('kalender.index');
    Route::put('/kalender', [\App\Http\Controllers\Admin\KalenderAkademikController::class, 'update'])->name('kalender.update');

    // Kurikulum
    Route::get('/kurikulum', [\App\Http\Controllers\Admin\KurikulumController::class, 'edit'])->name('kurikulum.edit');
    Route::put('/kurikulum', [\App\Http\Controllers\Admin\KurikulumController::class, 'update'])->name('kurikulum.update');

    // Pesan
    Route::get('/pesan', [PesanController::class, 'index'])->name('pesan.index');
    Route::get('/pesan/{pesan}', [PesanController::class, 'show'])->name('pesan.show');
    Route::delete('/pesan/{pesan}', [PesanController::class, 'destroy'])->name('pesan.destroy');

    // User Management
    Route::resource('users', AdminUserController::class)->except(['show']);

    // Setting Bobot
    Route::get('/setting-bobot', [SettingBobotController::class, 'index'])->name('setting-bobot.index');
    Route::put('/setting-bobot', [SettingBobotController::class, 'update'])->name('setting-bobot.update');

    // Log Aktivitas / Audit Trail
    Route::get('/logs', [ActivityLogController::class, 'index'])->name('logs.index');

    // Buku Tahunan CMS (Admin)
    Route::get('/admin/angkatan', [AdminAngkatanController::class, 'index'])->name('angkatan.index');
    Route::post('/admin/angkatan', [AdminAngkatanController::class, 'store'])->name('angkatan.store');
    Route::put('/admin/angkatan/{angkatan}', [AdminAngkatanController::class, 'update'])->name('angkatan.update');
    Route::delete('/admin/angkatan/{angkatan}', [AdminAngkatanController::class, 'destroy'])->name('angkatan.destroy');

    Route::get('/admin/kelas', [AdminKelasController::class, 'index'])->name('kelas.index');
    Route::post('/admin/kelas', [AdminKelasController::class, 'store'])->name('kelas.store');
    Route::put('/admin/kelas/{kela}', [AdminKelasController::class, 'update'])->name('kelas.update');
    Route::delete('/admin/kelas/{kela}', [AdminKelasController::class, 'destroy'])->name('kelas.destroy');

    Route::get('/admin/siswa', [AdminSiswaController::class, 'index'])->name('siswa.index');
    Route::post('/admin/siswa/import', [AdminSiswaController::class, 'importExcel'])->name('siswa.import');
    Route::get('/admin/siswa/export-kode', [AdminSiswaController::class, 'exportKode'])->name('siswa.export-kode');
    Route::put('/admin/siswa/{siswa}/approve', [AdminSiswaController::class, 'approve'])->name('siswa.approve');
    Route::put('/admin/siswa/{siswa}/reject', [AdminSiswaController::class, 'reject'])->name('siswa.reject');
    Route::post('/admin/siswa/bulk-approve', [AdminSiswaController::class, 'bulkApprove'])->name('siswa.bulk-approve');
    Route::delete('/admin/siswa/{siswa}', [AdminSiswaController::class, 'destroy'])->name('siswa.destroy');
});
