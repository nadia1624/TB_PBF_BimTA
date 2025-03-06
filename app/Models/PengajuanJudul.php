<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanJudul extends Model
{
    use HasFactory;

    protected $fillable = ['judul', 'deskripsi', 'komentar', 'approved_ta', 'tanda_tangan', 'surat', 'mahasiswa_id'];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}

