<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('dokumen_online', function (Blueprint $table) {
            $table->id();
            $table->enum('bab', ['bab 1', 'bab 2', 'bab 3', 'bab 4', 'bab 5', 'lengkap'])->nullable();
            $table->string('dokumen_mahasiswa')->nullable();
            $table->text('keterangan_mahasiswa')->nullable();
            $table->enum('status', ['menunggu', 'diproses', 'selesai']);
            $table->string('tanggal_review')->nullable();
            $table->string('dokumen_dosen')->nullable();
            $table->text('keterangan_dosen')->nullable();
            $table->foreignId('jadwal_bimbingan_id')->constrained('jadwal_bimbingan')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('dokumen_online');
    }
};
