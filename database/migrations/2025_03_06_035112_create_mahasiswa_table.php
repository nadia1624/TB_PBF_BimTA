<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nim')->unique();
            $table->string('nama_lengkap');
            $table->string('program_studi');
            $table->string('angkatan');
            $table->string('no_hp');
            $table->string('gambar')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('mahasiswa');
    }
};

