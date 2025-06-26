<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $table = 'dosen';

    protected $fillable = [
        'nip',
        'nama_lengkap',
        'gambar',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bidangKeahlian()
    {
        return $this->belongsToMany(BidangKeahlian::class, 'detail_bidang', 'dosen_id', 'bidang_keahlian_id');
    }

    public function detailBidang()
{
    return $this->hasMany(DetailBidang::class, 'dosen_id');
}

    public function pengajuanJudul()
    {
        return $this->belongsToMany(PengajuanJudul::class, 'detail_dosen', 'dosen_id', 'pengajuan_judul_id')
                    ->withPivot('pembimbing', 'status', 'alasan_dibatalkan');
    }

    public function jadwalBimbingan()
    {
        return $this->hasMany(JadwalBimbingan::class);
    }

    public function detailDosen()
    {
        return $this->hasMany(DetailDosen::class, 'dosen_id');
    }
}
