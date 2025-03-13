<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailBidang extends Model
{
    use HasFactory;
    
    protected $table = 'detail_bidang';
    protected $fillable = ['bidang_keahlian_id', 'dosen_id'];

    public function bidangKeahlian()
    {
        return $this->belongsTo(BidangKeahlian::class);
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }
}
