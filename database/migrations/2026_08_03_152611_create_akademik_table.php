<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('akademik', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->longText('konten');
            $table->enum('tipe', ['kurikulum', 'program_studi', 'kalender', 'info_akademik'])->default('info_akademik');
            $table->string('file_lampiran')->nullable();
            $table->boolean('is_aktif')->default(true);
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('akademik');
    }
};
