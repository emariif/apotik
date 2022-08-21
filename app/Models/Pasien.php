<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'telp',
        'resep',
        'pengirim',
        'alamat',
    ];

    public function penjualans()
    {
        return $this->hasMany(Penjualan::class, 'consumer', 'id');
    }
}
