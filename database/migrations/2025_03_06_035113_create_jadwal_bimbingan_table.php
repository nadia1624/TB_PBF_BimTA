<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('jadwal_bimbingan', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_pengajuan');
            $table->time('waktu_pengajuan');
            $table->enum('status', ['diproses', 'diterima', 'ditolak'])->default('diproses');
            $table->text('keterangan')->nullable();
            $table->foreignId('dosen_id')->constrained('dosen')->onDelete('cascade');
            $table->foreignId('pengajuan_judul_id')->constrained('pengajuan_judul')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('jadwal_bimbingan');
    }
};

