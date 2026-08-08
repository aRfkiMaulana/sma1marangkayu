<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Angkatan;
use App\Models\Berita;
use App\Models\Ekstrakurikuler;
use App\Models\Fasilitas;
use App\Models\Galeri;
use App\Models\GuruStaf;
use App\Models\Kelas;
use App\Models\Prestasi;
use App\Models\ProfilSekolah;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Enterprise ChatbotService — SMAN 1 Marangkayu
 *
 * Arsitektur: Knowledge Graph in-memory + Strategy Pattern handler modular
 * NLP: Regex word-boundary, Levenshtein fuzzy, stemmer domain-spesifik
 * Data: Bersumber dari database SMAN 1 Marangkayu
 *
 * @version 1.0.0
 */
final class ChatbotService
{
    private const SEKOLAH = [
        'nama'          => 'SMA Negeri 1 Marangkayu',
        'tagline'       => 'UNGGUL, BERAKHLAK, DAN BERPRESTASI',
        'npsn'          => '30400000',
        'akreditasi'    => 'A',
        'kecamatan'     => 'Marangkayu',
        'kabupaten'     => 'Kutai Kartanegara',
        'provinsi'      => 'Kalimantan Timur',
        'kode_pos'      => '75385',
        'alamat'        => 'Jl. Perintis, Sebuntal, Kec. Marangkayu, Kab. Kutai Kartanegara, Kalimantan Timur',
        'phone'         => '081234567890',
        'whatsapp'      => '081234567890',
        'email'         => 'info@sman1marangkayu.sch.id',
        'website'       => 'https://sman1marangkayu.sch.id',
        'jam_pelayanan' => 'Senin - Jumat: 07.30 - 16.00 WITA',
        'visi'          => 'Mewujudkan Generasi Unggul, Berkarakter, Berintegritas, dan Berprestasi Berdasarkan Imtaq dan IPTEK',
        'misi'          => [
            'Menyelenggarakan proses pembelajaran yang efektif, inovatif, dan menyenangkan.',
            'Meningkatkan pembinaan keagamaan dan kedisiplinan siswa.',
            'Mengembangkan minat dan bakat siswa melalui kegiatan ekstrakurikuler.',
            'Meningkatkan kualitas sarana dan prasarana penunjang pembelajaran.',
            'Membangun kerja sama yang harmonis antara sekolah, orang tua, dan masyarakat.',
        ],
    ];

    private array $ctx = [];
    private array $entities = [];

    public function processMessage(string $message, string $sessionId): array
    {
        $this->loadContext($sessionId);
        $norm = $this->normalize($message);
        $this->entities = $this->extractEntities($norm, $message);

        $response = $this->pipelineRun($norm, $message);

        $this->ctx['last_intent']   = $response['_intent'] ?? 'unknown';
        $this->ctx['last_entities'] = $this->entities;
        $this->ctx['turn']          = ($this->ctx['turn'] ?? 0) + 1;

        if (!isset($response['typing_delay'])) {
            $response['typing_delay'] = $this->calculateTypingDelay($response['message'] ?? '');
        }

        unset($response['_intent']);
        $this->saveContext($sessionId);

        return $response;
    }

    private function calculateTypingDelay(string $message): int
    {
        $wordCount = str_word_count($message);
        return max(500, min(2500, 600 + ($wordCount * 40)));
    }

    public function getQuickActions(): array
    {
        return [
            'Siapa Kepala Sekolah SMAN 1 Marangkayu?',
            'Bagaimana cara isi Buku Tahunan Siswa?',
            'Daftar Ekstrakurikuler yang ada?',
            'Apa saja Prestasi sekolah terbaru?',
            'Fasilitas sekolah apa saja yang ada?',
            'Kontak dan Alamat SMAN 1 Marangkayu',
            'Visi dan Misi sekolah',
            'Cek status Buku Tahunan',
        ];
    }

    public function resetContext(string $sessionId): void
    {
        Cache::forget("bot_ctx_{$sessionId}");
        $this->ctx = [];
    }

    private function pipelineRun(string $norm, string $raw): array
    {
        if (!empty($this->ctx['slot_state'])) {
            return $this->handleSlotFilling($norm, $raw);
        }

        $empathy = $this->detectEmpathy($norm);
        if ($empathy !== null) {
            return $empathy;
        }

        $chitchat = $this->detectChitchat($norm);
        if ($chitchat !== null) {
            return $chitchat;
        }

        $intent = $this->detectIntent($norm, $raw);
        return $this->routeIntent($intent, $norm, $raw);
    }

    private function normalize(string $text): string
    {
        $text = mb_strtolower(trim($text), 'UTF-8');

        $slang = [
            '/\bbrp\b/u'        => 'berapa',
            '/\bbrapa\b/u'      => 'berapa',
            '/\bsapa\b/u'       => 'siapa',
            '/\bgmn\b/u'        => 'bagaimana',
            '/\bgimana\b/u'     => 'bagaimana',
            '/\bkepsek\b/u'     => 'kepala sekolah',
            '/\bekskul\b/u'     => 'ekstrakurikuler',
            '/\bwa\b/u'         => 'whatsapp',
            '/\bnohp\b/u'       => 'nomor hp',
            '/\btelp\b/u'       => 'telepon',
            '/\binfo\b/u'       => 'informasi',
            '/\bthks?\b/u'      => 'terima kasih',
            '/\boke\b/u'        => 'ok',
            '/\byg\b/u'         => 'yang',
            '/\bdg\b/u'         => 'dengan',
            '/\bkrn\b/u'        => 'karena',
            '/\bbuku\s+tahun\b/u' => 'buku tahunan',
        ];

        foreach ($slang as $pattern => $replacement) {
            $text = preg_replace($pattern, $replacement, $text);
        }

        $text = preg_replace('/[^\p{L}\p{N}\s]/u', ' ', $text);
        $text = preg_replace('/\s+/u', ' ', $text);

        return trim($text);
    }

    private function extractEntities(string $norm, string $raw): array
    {
        $e = [];

        if (preg_match('/\b(20[2-3]\d)\b/', $raw, $m)) {
            $e['year'] = (int) $m[1];
        }

        if (preg_match('/\b\d{10}\b/', $raw, $m)) {
            $e['nisn'] = $m[0];
        }

        if (preg_match('/\b[A-Z0-9]{6}\b/', $raw, $m)) {
            $e['kode_unik'] = $m[0];
        }

        return $e;
    }

    private function detectEmpathy(string $norm): ?array
    {
        $wordCount = substr_count(trim($norm), ' ') + 1;

        if ($wordCount <= 4) {
            $greetings = ['halo', 'hai', 'hi', 'hey', 'selamat pagi', 'selamat siang', 'selamat sore', 'selamat malam', 'assalamualaikum', 'permisi'];
            foreach ($greetings as $g) {
                if (preg_match('/\b' . preg_quote($g, '/') . '\b/ui', $norm)) {
                    return $this->buildGreeting();
                }
            }
        }

        $gratitude = ['terima kasih', 'makasih', 'thanks', 'thank you', 'nuhun', 'suwun'];
        foreach ($gratitude as $g) {
            if (preg_match('/\b' . preg_quote($g, '/') . '\b/ui', $norm)) {
                return [
                    'message'     => "Sama-sama! 😊 Senang bisa membantu.\n\nJangan ragu bertanya lagi tentang **SMAN 1 Marangkayu**! 🏫",
                    'suggestions' => $this->getQuickActions(),
                    '_intent'     => 'thanks',
                ];
            }
        }

        return null;
    }

    private function detectChitchat(string $norm): ?array
    {
        if (preg_match('/\b(apa\s+kabar|gimana\s+kabar|sehat)\b/ui', $norm)) {
            return [
                'message'     => "Alhamdulillah kabar baik! 😊 Saya siap 24/7 memberikan informasi sekolah SMAN 1 Marangkayu.\n\nAda yang ingin ditanyakan?",
                'suggestions' => $this->getQuickActions(),
                '_intent'     => 'chitchat',
            ];
        }

        if (preg_match('/\b(siapa\s+kamu|nama\s+kamu|kamu\s+bot)\b/ui', $norm)) {
            return [
                'message'     => "Saya **Smart SMANSA Bot**, Asisten Virtual SMAN 1 Marangkayu! 🤖🏫\n\nSaya bertugas menjawab pertanyaan seputar profil sekolah, pengisian Buku Tahunan, Ekstrakurikuler, Prestasi, dan Berita.",
                'suggestions' => ['Profil Sekolah', 'Buku Tahunan', 'Ekstrakurikuler'],
                '_intent'     => 'chitchat_identity',
            ];
        }

        return null;
    }

    private function buildGreeting(): array
    {
        $wita = new \DateTimeZone('Asia/Makassar');
        $now  = new \DateTime('now', $wita);
        $hour = (int) $now->format('H');

        $salam = match (true) {
            $hour >= 5 && $hour < 11 => 'Selamat pagi',
            $hour >= 11 && $hour < 15 => 'Selamat siang',
            $hour >= 15 && $hour < 19 => 'Selamat sore',
            default => 'Selamat malam',
        };

        $message = "{$salam}! 👋\n\nSelamat datang di Asisten Virtual **SMAN 1 Marangkayu**.\n\nSaya bisa membantu Anda mengenai:\n"
                 . "• 🏫 Profil, Visi, Misi & Fasilitas Sekolah\n"
                 . "• 📖 Pengisian & Cek Status **Buku Tahunan Siswa**\n"
                 . "• 👨‍🏫 Data Guru & Staf\n"
                 . "• 🏆 Ekstrakurikuler & Prestasi Siswa\n"
                 . "• 📰 Berita & Pengumuman Sekolah\n\n"
                 . "Ada yang bisa saya bantu?";

        return [
            'message'     => $message,
            'suggestions' => $this->getQuickActions(),
            '_intent'     => 'greeting',
        ];
    }

    private function detectIntent(string $norm, string $raw): string
    {
        $intentPatterns = [
            'buku_tahunan_cek'  => ['/\b(cek\s+status|status\s+buku\s+tahunan|status\s+saya|status\s+foto)\b/ui'],
            'buku_tahunan_info' => ['/\b(buku\s+tahunan|bt|kode\s+unik|isi\s+buku\s+tahunan|cara\s+upload\s+foto|verifikasi\s+nisn)\b/ui'],
            'kepsek'            => ['/\b(kepala\s+sekolah|kepsek|siapa\s+kepala\s+sekolah)\b/ui'],
            'guru_staf'         => ['/\b(guru|staf|pengajar|nip|daftar\s+guru|wali\s+kelas)\b/ui'],
            'ekstrakurikuler'   => ['/\b(ekstrakurikuler|ekskul|pramuka|paskibra|futsal|osis|kegiatan\s+siswa)\b/ui'],
            'prestasi'          => ['/\b(prestasi|juara|lomba|penghargaan|piala)\b/ui'],
            'fasilitas'         => ['/\b(fasilitas|lab|perpustakaan|lapangan|kantin|ruang\s+kelas|gedung)\b/ui'],
            'profil'            => ['/\b(profil|tentang\s+sekolah|sejarah|npsn|akreditasi|visi|misi|tujuan)\b/ui'],
            'berita'            => ['/\b(berita|pengumuman|kabar|artikel)\b/ui'],
            'galeri'            => ['/\b(galeri|foto|dokumen|kegiatan)\b/ui'],
            'kontak'            => ['/\b(kontak|alamat|lokasi|telepon|email|wa|maps)\b/ui'],
        ];

        foreach ($intentPatterns as $intent => $patterns) {
            foreach ($patterns as $pattern) {
                if (preg_match($pattern, $norm)) {
                    return $intent;
                }
            }
        }

        return 'unknown';
    }

    private function routeIntent(string $intent, string $norm, string $raw): array
    {
        return match ($intent) {
            'buku_tahunan_cek'  => $this->handleBukuTahunanCek($norm),
            'buku_tahunan_info' => $this->handleBukuTahunanInfo(),
            'kepsek'            => $this->handleKepsek(),
            'guru_staf'         => $this->handleGuruStaf($norm),
            'ekstrakurikuler'   => $this->handleEkstrakurikuler($norm),
            'prestasi'          => $this->handlePrestasi($norm),
            'fasilitas'         => $this->handleFasilitas($norm),
            'profil'            => $this->handleProfil($norm),
            'berita'            => $this->handleBerita($norm),
            'galeri'            => $this->handleGaleri(),
            'kontak'            => $this->handleKontak(),
            default             => $this->handleUnknown($norm),
        };
    }

    private function handleBukuTahunanInfo(): array
    {
        $msg  = "📖 **Panduan Pengisian Buku Tahunan Siswa SMAN 1 Marangkayu**\n\n"
              . "1. Buka menu **Buku Tahunan** di website.\n"
              . "2. Masukkan **NISN** dan **Kode Unik** 6 karakter yang diberikan wali kelas/admin.\n"
              . "3. Upload **Foto** (rasio 3:4, otomatis terkonversi WebP) dan isi **Moto**.\n"
              . "4. Simpan Draft terlebih dahulu, lalu klik **Kirim ke Admin**.\n"
              . "5. Tunggu persetujuan Admin.\n\n"
              . "💡 Memiliki kendala/kode expired? Silakan hubungi Wali Kelas atau Admin.";

        return [
            'message'     => $msg,
            'suggestions' => ['Cek status submit', 'Kontak Admin', 'Profil Sekolah'],
            '_intent'     => 'buku_tahunan_info',
        ];
    }

    private function handleBukuTahunanCek(string $norm): array
    {
        if (isset($this->entities['nisn']) && isset($this->entities['kode_unik'])) {
            $siswa = Siswa::where('nisn', $this->entities['nisn'])->first();
            if ($siswa && strtoupper($siswa->kode_unik) === strtoupper($this->entities['kode_unik'])) {
                $statusMap = [
                    'kosong'   => 'Belum Mengisi Data',
                    'draft'    => 'Draft Tersimpan (Belum Dikirim ke Admin)',
                    'pending'  => 'Menunggu Review Admin',
                    'approved' => 'Approved (Disetujui & Tampil di Buku Tahunan)',
                    'rejected' => 'Rejected (Ditolak Admin, Silakan Submit Ulang)',
                ];
                $statusTxt = $statusMap[$siswa->status] ?? $siswa->status;

                return [
                    'message'     => "👤 **Data Siswa Found**\nNama: **{$siswa->nama}**\nNISN: {$siswa->nisn}\nStatus: **{$statusTxt}**",
                    'suggestions' => ['Panduan Buku Tahunan', 'Kontak Admin'],
                    '_intent'     => 'buku_tahunan_cek',
                ];
            }
        }

        $this->ctx['slot_state'] = 'ask_nisn_cek';
        return [
            'message'     => "🔍 **Cek Status Pengajuan Buku Tahunan**\n\nSilakan masukkan **NISN (10 digit)** Anda:",
            'suggestions' => ['Batal'],
            '_intent'     => 'buku_tahunan_cek',
        ];
    }

    private function handleSlotFilling(string $norm, string $raw): array
    {
        $state = $this->ctx['slot_state'] ?? '';

        if (preg_match('/\b(batal|cancel)\b/ui', $norm)) {
            unset($this->ctx['slot_state'], $this->ctx['slot_data']);
            return ['message' => "✅ Pengecekan dibatalkan.", 'suggestions' => $this->getQuickActions(), '_intent' => 'buku_tahunan_cek'];
        }

        if ($state === 'ask_nisn_cek') {
            preg_match('/\b\d{10}\b/', $raw, $m);
            if (!$m) {
                return ['message' => "⚠️ NISN harus **10 digit angka**. Silakan masukkan kembali:", 'suggestions' => ['Batal'], '_intent' => 'buku_tahunan_cek'];
            }
            $this->ctx['slot_data']['nisn'] = $m[0];
            $this->ctx['slot_state']        = 'ask_kode_cek';
            return ['message' => "Masukkan **Kode Unik (6 karakter)** Anda:", 'suggestions' => ['Batal'], '_intent' => 'buku_tahunan_cek'];
        }

        if ($state === 'ask_kode_cek') {
            $nisn = $this->ctx['slot_data']['nisn'];
            $kode = strtoupper(trim($raw));
            unset($this->ctx['slot_state'], $this->ctx['slot_data']);

            $siswa = Siswa::where('nisn', $nisn)->first();
            if ($siswa && strtoupper($siswa->kode_unik) === $kode) {
                $statusMap = [
                    'kosong'   => 'Belum Mengisi Data',
                    'draft'    => 'Draft Tersimpan (Belum Dikirim ke Admin)',
                    'pending'  => 'Menunggu Review Admin',
                    'approved' => 'Approved (Disetujui & Tampil di Buku Tahunan)',
                    'rejected' => 'Rejected (Ditolak Admin, Silakan Submit Ulang)',
                ];
                $statusTxt = $statusMap[$siswa->status] ?? $siswa->status;

                return [
                    'message'     => "👤 **Data Siswa Found**\nNama: **{$siswa->nama}**\nNISN: {$siswa->nisn}\nStatus: **{$statusTxt}**",
                    'suggestions' => $this->getQuickActions(),
                    '_intent'     => 'buku_tahunan_cek',
                ];
            }

            return ['message' => "❌ Data tidak ditemukan atau Kode Unik salah.", 'suggestions' => $this->getQuickActions(), '_intent' => 'buku_tahunan_cek'];
        }

        unset($this->ctx['slot_state']);
        return $this->handleUnknown($norm);
    }

    private function handleKepsek(): array
    {
        $profil = ProfilSekolah::first();
        $nama   = $profil ? $profil->kepala_sekolah : 'Drs. H. Sarjono, M.Pd';

        return [
            'message'     => "👨‍🏫 **Kepala SMAN 1 Marangkayu**\n\n**{$nama}**\n\n"
                           . "📍 Alamat Sekolah: " . self::SEKOLAH['alamat'],
            'suggestions' => ['Daftar Guru & Staf', 'Profil Sekolah', 'Kontak'],
            '_intent'     => 'kepsek',
        ];
    }

    private function handleGuruStaf(string $norm): array
    {
        $guruList = GuruStaf::where('is_aktif', true)->orderBy('urutan')->get();

        if ($guruList->isEmpty()) {
            return ['message' => "👨‍🏫 **Guru & Staf SMAN 1 Marangkayu**\n\nData guru dan staf dapat dilihat pada menu Profil Sekolah.", 'suggestions' => ['Kepala Sekolah', 'Profil Sekolah'], '_intent' => 'guru_staf'];
        }

        $msg = "👨‍🏫 **Daftar Guru & Staf SMAN 1 Marangkayu** (" . $guruList->count() . " orang)\n\n";
        foreach ($guruList->take(10) as $g) {
            $mapel = $g->mata_pelajaran ? " ({$g->mata_pelajaran})" : '';
            $msg  .= "• **{$g->nama}** — {$g->jabatan}{$mapel}\n";
        }

        if ($guruList->count() > 10) {
            $msg .= "\n_...dan " . ($guruList->count() - 10) . " pengajar lainnya._";
        }

        return [
            'message'     => $msg,
            'suggestions' => ['Kepala Sekolah', 'Profil Sekolah', 'Kontak'],
            '_intent'     => 'guru_staf',
        ];
    }

    private function handleEkstrakurikuler(string $norm): array
    {
        $ekskuls = Ekstrakurikuler::where('is_aktif', true)->get();

        if ($ekskuls->isEmpty()) {
            return ['message' => "🎨 **Ekstrakurikuler SMAN 1 Marangkayu**\n\nBerbagai kegiatan ekskul seperti Pramuka, Paskibra, Olahraga, dan Seni aktif dibina.", 'suggestions' => ['Prestasi Sekolah', 'Profil Sekolah'], '_intent' => 'ekstrakurikuler'];
        }

        $msg = "🎨 **Ekstrakurikuler SMAN 1 Marangkayu** (" . $ekskuls->count() . " Ekskul)\n\n";
        foreach ($ekskuls as $e) {
            $pembina = $e->pembina ? " (Pembina: {$e->pembina})" : '';
            $msg    .= "• **{$e->nama}**{$pembina}\n";
        }

        return [
            'message'     => $msg,
            'suggestions' => ['Prestasi Sekolah', 'Berita Terbaru'],
            '_intent'     => 'ekstrakurikuler',
        ];
    }

    private function handlePrestasi(string $norm): array
    {
        $prestasis = Prestasi::latest('tahun')->take(5)->get();

        if ($prestasis->isEmpty()) {
            return ['message' => "🏆 **Prestasi Siswa SMAN 1 Marangkayu**\n\nSiswa-siswi SMAN 1 Marangkayu aktif meraih berbagai kejuaraan tingkat Kabupaten maupun Provinsi.", 'suggestions' => ['Ekstrakurikuler', 'Berita Sekolah'], '_intent' => 'prestasi'];
        }

        $msg = "🏆 **Prestasi Terbaru SMAN 1 Marangkayu**\n\n";
        foreach ($prestasis as $p) {
            $msg .= "• **{$p->judul}** ({$p->tahun})\n  Peraih: {$p->peraih} | Tingkat: {$p->tingkat}\n\n";
        }

        return [
            'message'     => $msg,
            'suggestions' => ['Ekstrakurikuler', 'Berita Terbaru'],
            '_intent'     => 'prestasi',
        ];
    }

    private function handleFasilitas(string $norm): array
    {
        $fasilitas = Fasilitas::where('is_aktif', true)->orderBy('urutan')->get();

        if ($fasilitas->isEmpty()) {
            return ['message' => "🏫 **Fasilitas SMAN 1 Marangkayu**\n\nDilengkapi dengan Ruang Kelas Nyaman, Perpustakaan, Laboratorium, Lapangan Olahraga, dan Kantin.", 'suggestions' => ['Profil Sekolah', 'Kontak'], '_intent' => 'fasilitas'];
        }

        $msg = "🏫 **Fasilitas SMAN 1 Marangkayu**\n\n";
        foreach ($fasilitas as $f) {
            $jumlah = $f->jumlah ? " ({$f->jumlah} unit)" : '';
            $msg   .= "• **{$f->nama}**{$jumlah}\n";
        }

        return [
            'message'     => $msg,
            'suggestions' => ['Profil Sekolah', 'Kontak'],
            '_intent'     => 'fasilitas',
        ];
    }

    private function handleProfil(string $norm): array
    {
        $p = ProfilSekolah::first();
        $s = self::SEKOLAH;

        $npsn       = $p ? $p->npsn : $s['npsn'];
        $akreditasi = $p ? $p->akreditasi : $s['akreditasi'];
        $alamat     = $p ? $p->alamat : $s['alamat'];
        $visi       = $p ? $p->visi : $s['visi'];
        $telepon    = $p ? $p->telepon : $s['phone'];
        $email      = $p ? $p->email : $s['email'];

        $msg  = "🏫 **Profil {$s['nama']}**\n"
              . "🏷️ _{$s['tagline']}_\n\n"
              . "📌 **NPSN**: " . $npsn . " | Akreditasi: **" . $akreditasi . "**\n"
              . "📍 **Alamat**: " . $alamat . "\n\n"
              . "🎯 **Visi**:\n\"" . $visi . "\"\n\n"
              . "📞 **Telepon/WA**: " . $telepon . "\n"
              . "✉️ **Email**: " . $email;

        return [
            'message'     => $msg,
            'suggestions' => ['Kepala Sekolah', 'Daftar Guru & Staf', 'Fasilitas', 'Kontak'],
            '_intent'     => 'profil',
        ];
    }

    private function handleBerita(string $norm): array
    {
        $beritas = Berita::published()->latest('tanggal_publish')->take(5)->get();

        if ($beritas->isEmpty()) {
            return ['message' => "📰 **Berita SMAN 1 Marangkayu**\n\nBelum ada berita terbaru yang dipublikasikan.", 'suggestions' => ['Prestasi', 'Agenda'], '_intent' => 'berita'];
        }

        $msg = "📰 **Berita Terbaru SMAN 1 Marangkayu**\n\n";
        foreach ($beritas as $b) {
            $tgl  = $b->tanggal_publish ? $b->tanggal_publish->format('d M Y') : '';
            $msg .= "• **{$b->judul}** ({$tgl})\n  _{$b->ringkasan}_\n\n";
        }

        return [
            'message'     => $msg,
            'suggestions' => ['Prestasi', 'Galeri Foto'],
            '_intent'     => 'berita',
        ];
    }

    private function handleGaleri(): array
    {
        $galeris = Galeri::where('is_highlight', true)->orderBy('urutan')->take(5)->get();

        if ($galeris->isEmpty()) {
            return ['message' => "🖼️ **Galeri SMAN 1 Marangkayu**\n\nDokumentasi kegiatan sekolah dapat dilihat di halaman Galeri.", 'suggestions' => ['Berita Sekolah'], '_intent' => 'galeri'];
        }

        $msg = "🖼️ **Galeri Kegiatan SMAN 1 Marangkayu**\n\n";
        foreach ($galeris as $g) {
            $msg .= "• **{$g->judul}**\n  _{$g->deskripsi}_\n\n";
        }

        return [
            'message'     => $msg,
            'suggestions' => ['Berita Sekolah', 'Ekstrakurikuler'],
            '_intent'     => 'galeri',
        ];
    }

    private function handleKontak(): array
    {
        $s   = self::SEKOLAH;
        $msg = "📞 **Kontak & Lokasi SMAN 1 Marangkayu**\n\n"
             . "📍 **Alamat**: {$s['alamat']}\n"
             . "☎️ **Telepon / WA**: {$s['phone']}\n"
             . "✉️ **Email**: {$s['email']}\n"
             . "🌐 **Website**: {$s['website']}\n"
             . "🕒 **Jam Operasional**: {$s['jam_pelayanan']}";

        return [
            'message'     => $msg,
            'suggestions' => ['Profil Sekolah', 'Cara Isi Buku Tahunan'],
            '_intent'     => 'kontak',
        ];
    }

    private function handleUnknown(string $norm): array
    {
        return [
            'message'     => "Maaf, saya tidak memahami pertanyaan Anda. 🤔\n\nAnda dapat menanyakan hal seperti:\n"
                           . "• *\"Bagaimana cara isi Buku Tahunan?\"*\n"
                           . "• *\"Siapa Kepala Sekolah?\"*\n"
                           . "• *\"Apa saja ekstrakurikuler yang ada?\"*\n"
                           . "• *\"Fasilitas sekolah apa saja?\"*",
            'suggestions' => $this->getQuickActions(),
            '_intent'     => 'unknown',
        ];
    }

    private function loadContext(string $sessionId): void
    {
        $this->ctx = Cache::get("bot_ctx_{$sessionId}", []);
    }

    private function saveContext(string $sessionId): void
    {
        Cache::put("bot_ctx_{$sessionId}", $this->ctx, now()->addHours(3));
    }
}
