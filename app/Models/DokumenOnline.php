<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenOnline extends Model
{
    use HasFactory;

    protected $table = 'dokumen_online'; // Specify the correct table name

    protected $fillable = [
        'jadwal_bimbingan_id',
        'bab',
        'dokumen_mahasiswa',
        'keterangan_mahasiswa',
        'dokumen_dosen',
        'keterangan_dosen',
        'tanggal_review',
        'status'
    ];

    protected $casts = [
        'tanggal_review' => 'date',
    ];

    public function jadwalBimbingan()
    {
        return $this->belongsTo(JadwalBimbingan::class);  // Relasi kebalik dari jadwal bimbingan
    }
}
