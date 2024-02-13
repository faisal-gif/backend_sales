<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customer';
    protected $fillable = ['nama', 'nomor_telepon', 'alamat', 'paket_id', 'user_id', 'foto_ktp', 'foto_rumah'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
