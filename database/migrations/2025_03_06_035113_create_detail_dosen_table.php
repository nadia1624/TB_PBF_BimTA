<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('detail_dosen', function (Blueprint $table) {
            $table->foreignId('dosen_id')->constrained('dosen')->onDelete('cascade');
            $table->foreignId('pengajuan_judul_id')->constrained('pengajuan_judul')->onDelete('cascade');
            $table->enum('pembimbing', ['pembimbing 1', 'pembimbing 2']);
            $table->enum('status', ['diproses', 'diterima', 'ditolak'])->default('diproses');
            $table->text('alasan_dibatalkan')->nullable();
            $table->text('komentar')->nullable();
            $table->timestamps();

            $table->primary(['dosen_id', 'pengajuan_judul_id', 'pembimbing']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_dosen');
    }
};
