<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalBimbingan extends Model
{
    use HasFactory;

    protected $table = 'jadwal_bimbingan'; // Specify the correct table name here

    protected $fillable = ['tanggal_pengajuan', 'waktu_pengajuan', 'status', 'keterangan', 'dosen_id', 'pengajuan_judul_id', 'metode'];

    protected $casts = [
        'tanggal_pengajuan' => 'date',
        'waktu_pengajuan' => 'datetime',
    ];

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
        return $this->hasMany(DokumenOnline::class);
    }
}
