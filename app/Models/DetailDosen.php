<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailDosen extends Model
{
    use HasFactory;

    protected $fillable = ['dosen_id', 'pengajuan_judul_id'];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    public function pengajuanJudul()
    {
        return $this->belongsTo(PengajuanJudul::class);
    }
}
