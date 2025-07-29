<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('anamnesa', function (Blueprint $table) {
        $table->id();
        $table->foreignId('janji_id')->constrained('janji')->onDelete('cascade');
        $table->text('keluhan');         // Keluhan utama
        $table->text('pemeriksaan')->nullable();  // Pemeriksaan fisik jika ada
        $table->text('diagnosa')->nullable();     // Diagnosa dokter
        $table->text('tindakan')->nullable();     // Terapi / Obat
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anamnesa');
    }
};
