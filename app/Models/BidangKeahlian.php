<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidangKeahlian extends Model
{
    use HasFactory;

    protected $table = 'bidang_keahlian';
    protected $fillable = ['nama_keahlian'];
}
