<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailDosen extends Model
{
    use HasFactory;

    protected $table = 'detail_dosen';
    protected $primaryKey = ['dosen_id', 'pengajuan_judul_id'];
    public $incrementing = false;
    public $timestamps = true;
    protected $fillable = [
        'dosen_id',
        'pengajuan_judul_id',
        'pembimbing',
        'status',
        'alasan_dibatalkan'
    ];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }

    public function pengajuanJudul()
    {
        return $this->belongsTo(PengajuanJudul::class, 'pengajuan_judul_id');
    }
}
