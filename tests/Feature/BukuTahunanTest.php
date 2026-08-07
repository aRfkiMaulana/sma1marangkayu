<?php

namespace Tests\Feature;

use App\Models\Angkatan;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BukuTahunanTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_angkatan_and_kelas(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $resAngkatan = $this->actingAs($admin)->post('/panel-smansa/admin/angkatan', [
            'nama_angkatan' => 'Angkatan 2026',
            'tahun_lulus'   => 2026,
        ], ['Accept' => 'application/json']);

        $resAngkatan->assertStatus(201);
        $angkatanId = $resAngkatan->json('data.id');

        $resKelas = $this->actingAs($admin)->post('/panel-smansa/admin/kelas', [
            'nama_kelas'  => 'XII IPA 1',
            'angkatan_id' => $angkatanId,
        ], ['Accept' => 'application/json']);

        $resKelas->assertStatus(201);
        $this->assertDatabaseHas('kelas', ['nama_kelas' => 'XII IPA 1']);
    }

    public function test_full_buku_tahunan_siswa_flow(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create(['role' => 'admin']);

        $angkatan = Angkatan::create([
            'nama_angkatan' => 'Angkatan Garuda',
            'tahun_lulus'   => 2025,
            'dibuka_at'     => now()->subDay(),
            'ditutup_at'    => now()->addDays(10),
        ]);

        $kelas = Kelas::create([
            'nama_kelas'  => 'XII IPA 1',
            'angkatan_id' => $angkatan->id,
        ]);

        $siswa = Siswa::create([
            'kelas_id'        => $kelas->id,
            'nisn'            => '1234567890',
            'nama'            => 'Budi Santoso',
            'kode_unik'       => '7V7FZK',
            'kode_expired_at' => now()->addDays(7),
            'status'          => 'kosong',
        ]);

        // 1. Verifikasi
        $resVerify = $this->postJson('/buku-tahunan/verifikasi', [
            'nisn'      => '1234567890',
            'kode_unik' => '7V7FZK',
        ]);
        $resVerify->assertStatus(200)->assertJson(['nama' => 'Budi Santoso']);

        // 2. Simpan Draft
        $foto = UploadedFile::fake()->image('foto.jpg', 500, 500);
        $resDraft = $this->postJson('/buku-tahunan/simpan-draft', [
            'nisn'      => '1234567890',
            'kode_unik' => '7V7FZK',
            'foto'      => $foto,
            'moto'      => 'Sukses selalu',
        ]);
        $resDraft->assertStatus(200)->assertJsonPath('data.status', 'draft');

        // 3. Kirim ke Admin
        $resKirim = $this->postJson('/buku-tahunan/kirim-ke-admin', [
            'nisn'      => '1234567890',
            'kode_unik' => '7V7FZK',
        ]);
        $resKirim->assertStatus(200)->assertJsonPath('data.status', 'pending');

        // 4. Admin Approve
        $resApprove = $this->actingAs($admin)->putJson("/panel-smansa/admin/siswa/{$siswa->id}/approve");
        $resApprove->assertStatus(200)->assertJsonPath('data.status', 'approved');

        // 5. Public View Buku Tahunan
        $resPublic = $this->getJson('/buku-tahunan');
        $resPublic->assertStatus(200)->assertJsonCount(1, 'data');
    }

    public function test_reject_resets_siswa_to_draft(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create(['role' => 'admin']);

        $angkatan = Angkatan::create(['nama_angkatan' => 'Angkatan 1', 'tahun_lulus' => 2025]);
        $kelas = Kelas::create(['nama_kelas' => 'XII IPS 1', 'angkatan_id' => $angkatan->id]);

        $siswa = Siswa::create([
            'kelas_id'  => $kelas->id,
            'nisn'      => '0987654321',
            'nama'      => 'Siswa Reject',
            'kode_unik' => 'SMAM-2025-REJECT',
            'foto'      => 'buku-tahunan/2025/xii-ips-1/0987654321_123.jpg',
            'moto'      => 'Moto jelek',
            'status'    => 'pending',
        ]);

        $response = $this->actingAs($admin)->putJson("/panel-smansa/admin/siswa/{$siswa->id}/reject");
        $response->assertStatus(200)->assertJsonPath('data.status', 'draft');

        $siswaFresh = $siswa->fresh();
        $this->assertEquals('draft', $siswaFresh->status);
        $this->assertNull($siswaFresh->foto);
        $this->assertNull($siswaFresh->moto);
    }
}
