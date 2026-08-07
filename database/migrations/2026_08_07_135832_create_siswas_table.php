<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->string('nisn')->unique();
            $table->string('nama');
            $table->string('kode_unik')->unique();
            $table->timestamp('kode_expired_at')->nullable();
            $table->string('foto')->nullable();
            $table->string('moto')->nullable();
            $table->enum('status', ['kosong', 'draft', 'pending', 'approved', 'rejected'])->default('kosong');
            $table->foreignId('kelas_id')->constrained('kelas')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
