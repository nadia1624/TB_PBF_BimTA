<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenOnline extends Model
{
    use HasFactory;

    protected $fillable = ['bab', 'dokumen_mahasiswa', 'keterangan_mahasiswa', 'status', 'tanggal_review', 'dokumen_dosen', 'keterangan_dosen', 'jadwal_bimbingan_id'];

    public function jadwalBimbingan()
    {
        return $this->belongsTo(JadwalBimbingan::class);
    }
}
