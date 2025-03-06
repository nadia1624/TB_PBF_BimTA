<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalBimbingan extends Model
{
    use HasFactory;

    protected $fillable = ['tanggal_pengajuan', 'waktu_pengajuan', 'status', 'keterangan', 'dosen_id', 'pengajuan_judul_id'];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    public function pengajuanJudul()
    {
        return $this->belongsTo(PengajuanJudul::class);
    }
}
