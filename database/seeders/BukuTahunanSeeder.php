<?php

namespace Database\Seeders;

use App\Models\Angkatan;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Services\SiswaService;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class BukuTahunanSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $tahuns = [2024, 2025];

        foreach ($tahuns as $t) {
            $angkatan = Angkatan::create([
                'nama_angkatan' => 'Angkatan Lulusan ' . $t,
                'tahun_lulus'   => $t,
                'dibuka_at'     => now(),
                'ditutup_at'    => now()->addDays(14),
            ]);

            $namaKelasList = ['XII IPA 1', 'XII IPA 2', 'XII IPS 1'];

            foreach ($namaKelasList as $nk) {
                $kelas = Kelas::create([
                    'nama_kelas'  => $nk,
                    'angkatan_id' => $angkatan->id,
                ]);

                for ($k = 1; $k <= 10; $k++) {
                    Siswa::create([
                        'kelas_id'        => $kelas->id,
                        'nisn'            => $faker->unique()->numerify('##########'),
                        'nama'            => $faker->name,
                        'kode_unik'       => SiswaService::generateKodeUnik($t),
                        'kode_expired_at' => now()->addDays(7),
                        'status'          => 'kosong',
                    ]);
                }
            }
        }
    }
}
