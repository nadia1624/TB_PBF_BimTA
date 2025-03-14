<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $table = 'dosen';
    protected $fillable = ['nip', 'nama_lengkap', 'gambar', 'user_id'];

    // Relasi one-to-one dengan User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi one-to-many dengan DetailBidang
    public function detailBidang()
    {
        return $this->hasMany(DetailBidang::class);
    }

    // Relasi many-to-many dengan PengajuanJudul melalui DetailDosen
    public function pengajuanJudul()
    {
        return $this->belongsToMany(PengajuanJudul::class, 'detail_dosen')
            ->withPivot('pembimbing', 'status', 'alasan_dibatalkan')
            ->withTimestamps();
    }

    // Relasi one-to-many dengan DetailDosen
    public function detailDosen()
    {
        return $this->hasMany(DetailDosen::class);
    }
}

