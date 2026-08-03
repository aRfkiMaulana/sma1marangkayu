<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prestasi', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('peraih')->nullable();
            $table->enum('tingkat', ['sekolah', 'kecamatan', 'kabupaten', 'provinsi', 'nasional', 'internasional'])->default('sekolah');
            $table->enum('kategori', ['akademik', 'non_akademik', 'olahraga', 'seni'])->default('akademik');
            $table->integer('tahun');
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prestasi');
    }
};
