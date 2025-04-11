<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class DetailDosen extends Pivot
{
    use HasFactory;

    // Tambahkan ini di model DetailDosen
protected $primaryKey = ['dosen_id', 'pengajuan_judul_id'];

    // Untuk primary key komposit, sebaiknya gunakan Pivot class daripada Model
    public $incrementing = false;
    public $timestamps = true;
    protected $fillable = [
        'dosen_id',
        'pengajuan_judul_id',
        'pembimbing',
        'status',
        'alasan_dibatalkan',
        'komentar'
    ];

    // Relasi dengan Dosen
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }

    // Relasi dengan PengajuanJudul
    public function pengajuanJudul()
    {
        return $this->belongsTo(PengajuanJudul::class, 'pengajuan_judul_id');
    }
}
