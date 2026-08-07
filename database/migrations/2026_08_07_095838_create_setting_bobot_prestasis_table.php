<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('setting_bobot_prestasi', function (Blueprint $table) {
            $table->id();
            $table->string('tingkat')->unique();
            $table->integer('bobot');
            $table->timestamps();
        });

        $default = [
            ['tingkat' => 'internasional', 'bobot' => 100],
            ['tingkat' => 'nasional',      'bobot' => 75],
            ['tingkat' => 'provinsi',      'bobot' => 50],
            ['tingkat' => 'kabupaten',     'bobot' => 30],
            ['tingkat' => 'kecamatan',     'bobot' => 20],
            ['tingkat' => 'sekolah',       'bobot' => 10],
        ];

        foreach ($default as $d) {
            DB::table('setting_bobot_prestasi')->insert(array_merge($d, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('setting_bobot_prestasi');
    }
};
