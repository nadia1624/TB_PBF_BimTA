<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $fillable = ['nip', 'nama_lengkap', 'gambar', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
