<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa';
    protected $fillable = ['user_id', 'nim', 'nama_lengkap', 'program_studi', 'angkatan', 'no_hp', 'gambar'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pengajuanJudul()
    {
        return $this->hasMany(PengajuanJudul::class);
    }
}
