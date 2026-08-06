<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('prestasi', function (Blueprint $table) {
            $table->foreignId('ekstrakurikuler_id')
                  ->nullable()
                  ->after('tahun')
                  ->constrained('ekstrakurikuler')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('prestasi', function (Blueprint $table) {
            $table->dropForeignIdFor(\App\Models\Ekstrakurikuler::class);
            $table->dropColumn('ekstrakurikuler_id');
        });
    }
};
