<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanJudul extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_judul';

    protected $fillable = [
        'judul',
        'deskripsi',
        'komentar',
        'approved_ta',
        'tanda_tangan',
        'surat',
        'mahasiswa_id'
    ];

    // Relasi many-to-one dengan Mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function jadwalBimbingan()
    {
        return $this->hasMany(JadwalBimbingan::class);

    // Relasi many-to-many dengan Dosen melalui DetailDosen
    public function dosen()
    {
        return $this->belongsToMany(Dosen::class, 'detail_dosen')
            ->withPivot('pembimbing', 'status', 'alasan_dibatalkan')
            ->withTimestamps();
    }

    // Relasi one-to-many dengan DetailDosen
    public function detailDosen()
    {
        return $this->hasMany(DetailDosen::class);

    }
}

