<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pengajuan_judul', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('komentar')->nullable();
            $table->enum('approved_ta', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->string('tanda_tangan')->nullable();
            $table->string('surat')->nullable();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswa')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('pengajuan_judul');
    }
};
