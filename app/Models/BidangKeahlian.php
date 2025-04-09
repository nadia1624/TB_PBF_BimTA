<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidangKeahlian extends Model
{
    use HasFactory;

    protected $table = 'bidang_keahlian';

    protected $fillable = [
        'nama_keahlian'
    ];

    public function dosen()
    {
        return $this->belongsToMany(Dosen::class, 'detail_bidang', 'bidang_keahlian_id', 'dosen_id');
    }
}
