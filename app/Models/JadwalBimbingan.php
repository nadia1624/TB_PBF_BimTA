<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalBimbingan extends Model
{
    use HasFactory;

    protected $table = 'jadwal_bimbingan';

    protected $fillable = [
        'tanggal_pengajuan',
        'waktu_pengajuan',
        'status',
        'keterangan',
        'keterangan_ditolak',
        'keterangan_diterima_offline',  // Menambahkan keterangan_diterima_offline
        'metode',
        'dosen_id',
        'pengajuan_judul_id'
    ];

    protected $casts = [
        'tanggal_pengajuan' => 'date',
        'waktu_pengajuan' => 'datetime',
    ];

    // Konstanta untuk metode bimbingan
    const METODE_ONLINE = 'online';
    const METODE_OFFLINE = 'offline';

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    public function pengajuanJudul()
    {
        return $this->belongsTo(PengajuanJudul::class);
    }

    public function dokumenOnline()
    {
        return $this->hasOne(DokumenOnline::class);  // Mengubah relasi menjadi hasOne untuk 1 jadwal bimbingan 1 dokumen online
    }
}
